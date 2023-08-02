<?php

namespace App\Http\Controllers;

use App\Models\CrmClaimRewardHistory;
use App\Models\CrmPoin;
use App\Models\CrmReward;
use App\Models\PoinCrm;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ReturCashier;
use App\Models\ReturCashierHistory;
use App\Models\TransactionDetail;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\ReturHistory;
use App\Models\ReturDetail;
use App\Models\SalesStokDetail;
use App\Models\SalesStokHistory;

class NotificationManageController extends Controller
{
    public function index()
    {
        if (auth()->user()->id_group == 1) {
            // superadmin
            $produk_sedikit = Product::where('id_group', auth()->user()->id_group)->where('stok', '<', '50')->get();
            $transaksi_pending = TransactionHistory::join('users', 'users.id', '=', 'transaction_histories.id_owner')->where('users.user_position', 'superadmin_distributor')->where('status_pesanan', 0)->select('transaction_histories.*')->orderBy('id', 'desc')->get();
            $supplier = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $retur_pending = ReturHistory::with('transaction')->where('id_supplier', $supplier->id)->where('status_retur', 0)->orderBy('id', 'desc')->get();
            $retur_cashier_pending = ReturCashierHistory::with('transaction')->where('id_supplier', $supplier->id)->where('status_retur', 0)->orderBy('id', 'desc')->get();
            $reward_pending = CrmClaimRewardHistory::where('status', 0)->orderBy('id', 'desc')->get();

            return view('notification', compact(['produk_sedikit', 'transaksi_pending', 'retur_pending', 'retur_cashier_pending', 'reward_pending']));
        } else if (auth()->user()->user_position == 'superadmin_distributor') {
            // distributor
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $produk_sedikit = Product::where('id_owner', $distributor->id)->where('stok', '<', '50')->get();
            $transaksi_pending = TransactionHistory::join('users', 'users.id', '=', 'transaction_histories.id_owner')->where('users.user_position', 'reseller')->where('status_pesanan', 0)->select('transaction_histories.*')->orderBy('id', 'desc')->get();
            $seller = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->first();
            $retur_pending = ReturHistory::with('transaction')->where('id_owner', $seller->id)->where('id_approve', 0)->orderBy('id', 'desc')->get();
            $retur_cashier_pending = ReturCashierHistory::with('transaction')->where('id_supplier', $seller->id)->where('status_retur', 0)->orderBy('id', 'desc')->get();
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            // $count_rewards = CrmReward::where('type', 'distributor')->where('poin', '<=', $owner->crm_poin)->count();
            $rewards = CrmReward::where('type', 'distributor')->where('poin', '<=', $distributor->crm_poin)->orderBy('id', 'desc')->get();

            return view('notification', compact(['produk_sedikit', 'transaksi_pending', 'retur_pending', 'retur_cashier_pending', 'rewards', 'owner']));
        } else if (auth()->user()->user_position == "reseller") {
            // reseller
            $produk_sedikit = Product::where('id_owner', auth()->user()->id)->where('stok', '<', '50')->get();
            // $transaksi_pending = 0;
            // $retur_pending = 0;
            $owner = auth()->user();
            $rewards = CrmReward::where('type', 'reseller')->where('poin', '<=', $owner->crm_poin)->orderBy('id', 'desc')->get();

            return view('notification', compact(['produk_sedikit', 'rewards', 'owner']));
        } else if (auth()->user()->user_position == "sales") {
            // sales
            $produk_sedikit = Product::where('id_owner', auth()->user()->id)->where('stok', '<', '50')->get();
            $terima_stoks = SalesStokHistory::where('id_owner', auth()->user()->id)->where('status', '=', 0)->get();

            $owner = auth()->user();
            $rewards = CrmReward::where('type', 'reseller')->where('poin', '<=', $owner->crm_poin)->orderBy('id', 'desc')->get();

            return view('notification', compact(['produk_sedikit', 'terima_stoks', 'rewards', 'owner']));
        }
        return back();
    }

    public function editDetailTransaction(Request $request, $detail_id)
    {
        $detail = TransactionDetail::where('id', $detail_id)->first();
        dd($request->jumlah_baru);
    }

    public function approveTransaction(Request $request, $transaction_id)
    {
        // dd($request);
        // $request->input("jumlah_produk".$i)
        if (auth()->user()->acc_transaksi == 1) {

            $transaksi = TransactionHistory::where('id', $transaction_id)->first();
            $details = TransactionDetail::where('id_transaction', $transaction_id)->get();
            // CEK STOK CUKUP / TIDAK
            $stok_tersedia = true;
            $list = "";

            foreach ($details as $detail) {
                $produk = Product::where('id', $detail->id_product)->first();
                if ($request->input("jumlah" . $detail->id) > $produk->stok) {
                    $stok_tersedia = false;
                    $list .= " *";
                    $list .= $produk->product_type->nama_produk;
                }
            }

            if ($stok_tersedia) {
                $newTotal = 0;
                $total_crm_poin_distributor = 0;

                foreach ($details as $detail) {
                    $produkKurang = Product::where('id', $detail->id_product)->first();
                    $kurang_stok = $produkKurang->stok - $request->input("jumlah" . $detail->id);
                    $produkKurang->update(array('stok' => $kurang_stok));
                    if ($kurang_stok > 0) {
                        $keteranganStok = 'Tersedia';
                    } else {
                        $keteranganStok = 'Kosong';
                    }
                    $produkKurang->update(array('keterangan' => $keteranganStok));

                    $produkTambah = Product::where('id_owner', $transaksi->id_owner)->where('id_productType', $produkKurang->id_productType)->first();
                    // $tambah_stok = $produkTambah->stok + $detail->jumlah;
                    $tambah_stok = $produkTambah->stok + $request->input("jumlah" . $detail->id);
                    $produkTambah->update(array('stok' => $tambah_stok));
                    if ($tambah_stok > 0) {
                        $keteranganStok = 'Tersedia';
                    } else {
                        $keteranganStok = 'Kosong';
                    }
                    $produkTambah->update(array('keterangan' => $keteranganStok));

                    $detail->update(array('jumlah' => $request->input("jumlah" . $detail->id)));
                    $detail->update(array('total' => $request->input("jumlah" . $detail->id) * $detail->harga));
                    $newTotal += $request->input("jumlah" . $detail->id) * $detail->harga;

                    $crm_poin = CrmPoin::where('id_productType', $produkKurang->id_productType)->first();

                    if (User::where('id', $transaksi->id_owner)->first()->user_position == "reseller") {
                        $detail->update(array('crm_poin_distributor' => $crm_poin->distributor_jual * $request->input("jumlah" . $detail->id)));
                        $total_crm_poin_distributor += $crm_poin->distributor_jual * $request->input("jumlah" . $detail->id);
                    }
                }

                $transaksi->update(array('total' => $newTotal));
                $transaksi->update(array('status_pesanan' => 1));
                $transaksi->update(array('id_approve' => auth()->user()->id));
                $transaksi->update(array('nama_approve' => auth()->user()->firstname . " " . auth()->user()->lastname));


                if (User::where('id', $transaksi->id_owner)->first()->user_position == "superadmin_distributor") {
                    $owner = "distributor";
                } else {
                    $owner = "reseller";
                    $transaksi->update(array('total_crm_poin_distributor' => $total_crm_poin_distributor));
                    $dist = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                    $dist->update(array('crm_poin' => $total_crm_poin_distributor + $dist->crm_poin));
                }
                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $newActivity['kegiatan'] = "Approve transaksi " . $owner . " '" . $transaksi->transaction_code . "'";
                UserHistory::create($newActivity);

                Session::flash('approve_transaction_success', 'Transaksi berhasil');
            } else {
                Session::flash('approve_transaction_failed', 'produk :' . $list . ' kurang');
            }
        }
        return back();
    }

    public function printKlaimReward($reward_id)
    {
        $reward = CrmClaimRewardHistory::where("id", $reward_id)->first();
        return view('notification.printKlaimReward', compact(["reward"]));
    }

    public function approveReturPenjualan($retur_id)
    {
        if (auth()->user()->acc_retur == 1) {
            $retur = ReturCashierHistory::where('id', $retur_id)->get();
            $details = ReturCashier::where('id_retur', $retur_id)->get();

            foreach ($details as $detail) {
                $produkKurang = Product::where('id', $detail->id_product)->first();
                $kurang_stok = $produkKurang->stok - $detail->jumlah;
                $produkKurang->update(array('stok' => $kurang_stok));
                if ($kurang_stok > 0) {
                    $keteranganStok = 'Tersedia';
                } else {
                    $keteranganStok = 'Kosong';
                }
                $produkKurang->update(array('keterangan' => $keteranganStok));
            }
            $retur->update(array('status_retur' => 1));
            $retur->update(array('id_approve' => auth()->user()->id));
            $retur->update(array('nama_approve' => auth()->user()->firstname . " " . auth()->user()->lastname));

            if (User::where('id', $retur->id_owner)->first()->user_position == "superadmin_distributor") {
                $owner = "distributor";
            } else {
                $owner = User::where('id', $retur->id_owner)->first()->user_position;
            }
            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Approve Retur " . $owner . " '" . $retur->surat_keluar . "'";
            UserHistory::create($newActivity);

            Session::flash('approve_transaction_success', 'Retur berhasil');
        }

        return back();
    }

    public function approveReturPembelian($retur_id)
    {
        if (auth()->user()->acc_retur == 1) {
            $retur = ReturHistory::where('id', $retur_id)->first();
            $details = ReturDetail::where('id_retur', $retur_id)->get();

            foreach ($details as $detail) {
                $produkKurang = Product::where('id', $detail->id_product)->first();
                $kurang_stok = $produkKurang->stok - $detail->jumlah;
                $produkKurang->update(array('stok' => $kurang_stok));
                if ($kurang_stok > 0) {
                    $keteranganStok = 'Tersedia';
                } else {
                    $keteranganStok = 'Kosong';
                }
                $produkKurang->update(array('keterangan' => $keteranganStok));
            }
            $retur->update(array('status_retur' => 1));
            $retur->update(array('id_approve' => auth()->user()->id));
            $retur->update(array('nama_approve' => auth()->user()->firstname . " " . auth()->user()->lastname));

            if (User::where('id', $retur->id_owner)->first()->user_position == "superadmin_distributor") {
                $owner = "distributor";
            } else {
                $owner = User::where('id', $retur->id_owner)->first()->user_position;
            }
            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Approve Retur " . $owner . " '" . $retur->surat_keluar . "'";
            UserHistory::create($newActivity);

            Session::flash('approve_transaction_success', 'Retur berhasil');
        }

        return back();
    }

    function printTransaction($idTransaksi)
    {
        $transaction = TransactionHistory::where('id', $idTransaksi)->first();
        $pembeli = User::where('id', $transaction->id_owner)->first();
        $details = TransactionDetail::where('id_transaction', $idTransaksi)->get();
        return view('notification.printTransaction', compact(['transaction', 'pembeli', 'details']));
    }

    function printReturPenjualan($idRetur)
    {
        $retur = ReturCashierHistory::where('id', $idRetur)->first();
        $peretur = User::where('id', $retur->id_owner)->first();
        if ($peretur->user_position == "sales") {
            $transaction = SalesStokHistory::where('id', $retur->id_transaction)->first();
        } else {
            $transaction = TransactionHistory::where('id', $retur->id_transaction)->first();
        }
        $details = ReturCashier::where('id_retur', $idRetur)->get();
        return view('notification.printRetur', compact('retur', 'transaction', 'peretur', 'details'));
    }

    function printReturPembelian($idRetur)
    {
        $retur = ReturHistory::where('id', $idRetur)->first();
        $peretur = User::where('id', $retur->id_owner)->first();
        if ($peretur->user_position == "sales") {
            $transaction = SalesStokHistory::where('id', $retur->id_transaction)->first();
        } else {
            $transaction = TransactionHistory::where('id', $retur->id_transaction)->first();
        }
        $details = ReturDetail::where('id_retur', $idRetur)->get();
        return view('notification.printRetur', compact('retur', 'transaction', 'peretur', 'details'));
    }

    function approveClaimReward($reward_history_id)
    {
        if (auth()->user()->acc_reward == 1) {
            $history = CrmClaimRewardHistory::where('id', $reward_history_id)->first();
            $history->update(array('status' => 1));
            $history->update(array('id_approve' => auth()->user()->id));
            $history->update(array('nama_approve' => auth()->user()->firstname . " " . auth()->user()->lastname));

            $owner = User::where('id', $history->id_owner)->first();
            $owner->update(array('crm_poin' => $owner->crm_poin - $history->poin));

            if (User::where('id', $history->id_owner)->first()->user_position == "reseller") {
                $owner = "reseller";
            } else {
                $owner = "distributor";
            }

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Approve Claim reward " . $owner . " '" . $history->reward . "'";
            UserHistory::create($newActivity);

            Session::flash('approve_claim_reward_success', 'Claim Reward berhasil');
        }

        return back();
    }

    function approveTerimaStok($id_terimaStok)
    {
        if (auth()->user()->user_position == "sales") {
            $history = SalesStokHistory::where('id', $id_terimaStok)->first();

            $details = SalesStokDetail::where('id_sales_stok', $history->id)->get();

            foreach ($details as $detail) {
                $salesProduk = Product::where('id', $detail->id_product)->first();

                $salesProduk->update(array('stok' => $salesProduk->stok + $detail->jumlah));
            }

            $history->update(array('status' => 1));
            $history->update(array('id_approve' => auth()->user()->id));
            $history->update(array('nama_approve' => auth()->user()->firstname . " " . auth()->user()->lastname));

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Approve terima stok";
            UserHistory::create($newActivity);

            Session::flash('approve_terima_stok', 'Stok telah diterima');
        }

        return back();
    }

    public function claimReward(Request $request, $id)
    {
        if (auth()->user()->lihat_crm == 1) {
            if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                $validateData['id_owner'] = $owner->id;
                $validateData['sisa_poin'] = $owner->crm_poin;
            } else if (auth()->user()->user_position == "reseller" || auth()->user()->user_position == "sales") {
                $validateData['id_owner'] = auth()->user()->id;
                $validateData['sisa_poin'] = auth()->user()->crm_poin;
            }
            $validateData['id_group'] = auth()->user()->id_group;
            $validateData['id_input'] = auth()->user()->id;
            $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;
            $validateData['id_reward'] = $request->id_reward;

            $reward = CrmReward::where('id', $request->id_reward)->first();
            $validateData['reward'] = $reward->reward;
            $validateData['poin'] = $reward->poin;
            $validateData['detail_reward'] = $reward->detail;
            $validateData['image'] = $reward->image;
            $validateData['status'] = 0;

            CrmClaimRewardHistory::create($validateData);

            Session::flash('claim_success', 'Hadiah berhasil diclaim');
            return redirect('/notification');
        }

        return back();
    }
}
