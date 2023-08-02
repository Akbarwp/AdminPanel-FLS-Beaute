<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TransactionHistory;
use App\Models\ProductType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\CrmPoin;
use App\Models\PoinCrm;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailSell;
use App\Models\TransactionHistorySell;
use Illuminate\Http\Request;
use App\Models\UserHistory;
use Illuminate\Support\Carbon;
use App\Exports\TransactionHistoryExport;
use App\Exports\TransactionSellExport;
use App\Models\CashOpname;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use App\Imports\TransactionImport;
use App\Imports\TransactionSellImport;
use PDF;


class TransactionManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentDate = Carbon::now()->toDateString();
        if (auth()->user()->input_pos == 1) {
            $opname = CashOpname::where('user_id', auth()->user()->id)->whereDate('created_at', $currentDate)->first();
            $latest_transaction = TransactionHistory::latest()->first();
            return view('manage_transactions.transaction', compact(['latest_transaction', 'opname']));
        }
        return back();
    }

    public function history()
    {
        if (auth()->user()->lihat_pos == 1) {
            return view('manage_transactions.transaction_history');
        }
        return back();
    }

    public function transactionSell()
    {
        $currentDate = Carbon::now()->toDateString();
        if (auth()->user()->input_pos == 1) {
            $opname = CashOpname::where('user_id', auth()->user()->id)->whereDate('created_at', $currentDate)->first();
            $latest_transaction = TransactionHistorySell::latest()->first();
            return view('manage_transactions.transaction_sell', compact(['latest_transaction', 'opname']));
        }
        return back();
    }

    public function historySell()
    {
        if (auth()->user()->lihat_pos == 1) {
            return view('manage_transactions.transaction_history_sell');
        }
        return back();
    }

    public function getList()
    {
        if (auth()->user()->id_group == 1) {
            //test reseller
            // $idDistributor = User::where('id_group',3)->where('user_position', 'superadmin_distributor')->first();
            // $products = Product::where('id_group',3)->where('id_owner', $idDistributor->id)->select('*')->get();

            //test distributor
            $idPabrik = User::where('user_position', 'superadmin_pabrik')->first();
            $products = Product::where('id_owner', $idPabrik->id)->select('*')->get();

            $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
            foreach ($products as $product) {
                $productName = ProductType::where('id', $product->id_productType)->first();
                $output .= '<option value=' . $product->id . '>' . $productName->nama_produk . '</option>';
            }

            return response()->json($output);
        } else if (auth()->user()->user_position != "reseller") {
            $idPabrik = User::where('user_position', 'superadmin_pabrik')->first();
            $products = Product::where('id_owner', $idPabrik->id)->select('*')->get();
            $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
            foreach ($products as $product) {
                $productName = ProductType::where('id', $product->id_productType)->first();
                $output .= '<option value=' . $product->id . '>' . $productName->nama_produk . '</option>';
            }

            return response()->json($output);
        } else if (auth()->user()->user_position == "reseller") {
            $idDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $products = Product::where('id_group', auth()->user()->id_group)->where('id_owner', $idDistributor->id)->select('*')->get();
            $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
            foreach ($products as $product) {
                $productName = ProductType::where('id', $product->id_productType)->first();
                $output .= '<option value=' . $product->id . '>' . $productName->nama_produk . '</option>';
            }

            return response()->json($output);
        }
    }

    public function getStokTersedia(Request $request)
    {
        $produkPusat = Product::where('id', $request->id_produk)->first();

        $stokTersedia = $produkPusat->stok;

        return response()->json(["stokTersedia" => $stokTersedia]);
    }

    public function getDistributorName()
    {
        $output = '';
        $id = auth()->user()->id_group;
        $distributor = User::where('id_group', $id)->where('user_position', 'superadmin_distributor')->first();
        $output .= '                   
        <div class="col-sm text-left">
            <p style="font-weight:500">Nama Distributor</p>
        </div>
        <div class="col-sm text-right">
            <p>' . $distributor->username . '</p>
        </div>';
        return response()->json($output);
    }

    public function checkItem(Request $request)
    {
        if (auth()->user()->user_position == "reseller") {
            $detailProduct = Product::find($request->idItem);
            return response()->json(["code" => "check", "detail" => $detailProduct]);
        } else {
            $detailProduct = Product::find($request->idItem);
            return response()->json(["code" => "non", "detail" => $detailProduct]);
        }
    }

    public function order(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $transHistory = new TransactionHistory();
        $transDetail = new TransactionDetail();
        if (auth()->user()->user_position == "reseller") {
            $idDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            $data = [
                'transaction_code' => $request->transactionCode,
                'id_group' => auth()->user()->id_group,
                'id_distributor' => $idDistributor->id,
                'id_owner' => auth()->user()->id,
                'id_input' => auth()->user()->id,
                'nama_input' => auth()->user()->firstname . " " . auth()->user()->lastname,
                'jumlah_barang' => $request->jumlahBarang,
                'tanggal_pesan' => date("Y-m-d"),
                'jam_pesan' => date("h:i:sa"),
                'total' => $request->total,
                // 'lokasi' => $request->lokasi,
                'status_pesanan' => 0,
                'metode_pembayaran' => $request->metode_pembayaran,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $transHistory->DBaddHistories($data);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Create transaksi '" . $data['transaction_code'] . "'";
            UserHistory::create($newActivity);

            $lastId = TransactionHistory::orderBy('id', 'DESC')->first();
            $lastId = $lastId->id;

            $dataBarang = $request->cart;

            for ($i = 0; $i < count($dataBarang); $i++) {
                // Reseller beli = distributor jual = distributor dapat poin
                $detail = [
                    'id_transaction' => $lastId,
                    'nama_produk' => $dataBarang[$i][0],
                    'jumlah' => $dataBarang[$i][1],
                    'harga' => $dataBarang[$i][2],
                    'total' => $dataBarang[$i][3],
                    'id_product' => $dataBarang[$i][4],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $transDetail->DBaddDetails($detail);
            }

            return response()->json(["code" => "check"]);
        } else {
            $idDistributor = User::where('user_position', 'superadmin_pabrik')->first();
            $idOwner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            $data = [
                'transaction_code' => $request->transactionCode,
                'id_group' => auth()->user()->id_group,
                'id_distributor' => $idDistributor->id,
                'id_owner' => $idOwner->id,
                'id_input' => auth()->user()->id,
                'nama_input' => auth()->user()->firstname . " " . auth()->user()->lastname,
                'jumlah_barang' => $request->jumlahBarang,
                'tanggal_pesan' => date("Y-m-d"),
                'jam_pesan' => date("h:i:sa"),
                'total' => $request->total,
                // 'lokasi' => $request->lokasi,
                'status_pesanan' => 0,
                'metode_pembayaran' => $request->metode_pembayaran,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $transHistory->DBaddHistories($data);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Create transaksi '" . $data['transaction_code'] . "'";
            UserHistory::create($newActivity);

            $lastId = TransactionHistory::orderBy('id', 'DESC')->first();
            $lastId = $lastId->id;

            $dataBarang = $request->cart;

            for ($i = 0; $i < count($dataBarang); $i++) {
                $detail = [
                    'id_transaction' => $lastId,
                    'nama_produk' => $dataBarang[$i][0],
                    'jumlah' => $dataBarang[$i][1],
                    'harga' => $dataBarang[$i][2],
                    'total' => $dataBarang[$i][3],
                    'id_product' => $dataBarang[$i][4],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $transDetail->DBaddDetails($detail);
            }



            return response()->json(["code" => "non"]);
        }
    }

    public function getHistory()
    {
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            $histories = TransactionHistory::where('id_owner', auth()->user()->id)->select('*')->get();
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->id_distributor != 1) {
                $distributor = User::where('id_group', $history->id_group)->where('user_position', 'superadmin_distributor')->first();
                $disName = $distributor->username;
            } else {
                $disName = "Pabrik";
            }

            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $direct = url('/manage_transaction/transaction_history/printDetail/' . $history->id);
            $output .= '
            <tr>
                <td>' . $history->transaction_code . '</td>
                <td>' . $disName . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td>' . $status . '</td>
                <td>' . $history->updated_at->format('d/m/y H:i:s') . '</td>
                <td>' . $history->metode_pembayaran . '</td>
                <td>
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit" ></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link " onclick="#" data-toggle="collapse" data-target="#tr' . $ctr . '" aria-expanded="false" aria-controls="tr' . $ctr . '">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="collapse" id="tr' . $ctr . '">
                <td colspan="7">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm text-left">
                            
                            <p style="font-size:12px;color:grey;font-weight:500"></p>	
                        </div>
                        <div class="col-sm text-right">
                            <p>Jumlah Barang : ' . $history->jumlah_barang . '</p>
                        </div>
                    </div>
                    <table class="table table-hover table-light">
                        <tbody>';

            $details = TransactionDetail::where('id_transaction', $history->id)->select('*')->get();
            $ctr1 = 1;
            foreach ($details as $detail) {
                $output .= '
                            <tr>
                                <td class="align-middle">' . $ctr1 . '</td>
                                <td class="align-middle">' . $detail->nama_produk . '</td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                        <p style="font-weight:500;">' . $detail->jumlah . ' pcs</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->harga, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->total, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                            </tr>';
                $ctr1++;
            }

            $output .= '                   
                    </tbody>
                    </table>
                </td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>

            </tr>
                ';
            $ctr++;
        }
        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function getPenjualName()
    {
        $output = '';
        $output .= '                   
        <div class="col-sm text-left">
            <p style="font-weight:500">Nama Penjual</p>
        </div>
        <div class="col-sm text-right">
            <p>' . auth()->user()->username . '</p>
        </div>';
        return response()->json($output);
    }

    public function getListSeller()
    {
        if (auth()->user()->id_group == 1) {
            $owner = User::where('user_position', 'superadmin_pabrik')->first();
            $products = Product::where('id_owner', $owner->id)->select('*')->get();

            $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
            foreach ($products as $product) {
                $productName = ProductType::where('id', $product->id_productType)->first();
                $output .= '<option value=' . $product->id . '>' . $productName->nama_produk . '</option>';
            }

            return response()->json($output);
        } else if (auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $products = Product::where('id_owner', $owner->id)->select('*')->get();
            $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
            foreach ($products as $product) {
                $productName = ProductType::where('id', $product->id_productType)->first();
                $output .= '<option value=' . $product->id . '>' . $productName->nama_produk . '</option>';
            }

            return response()->json($output);
        } else if (auth()->user()->user_position == "reseller") {
            $products = Product::where('id_group', auth()->user()->id_group)->where('id_owner', auth()->user()->id)->select('*')->get();
            $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
            foreach ($products as $product) {
                $productName = ProductType::where('id', $product->id_productType)->first();
                $output .= '<option value=' . $product->id . '>' . $productName->nama_produk . '</option>';
            }

            return response()->json($output);
        }
    }

    public function sell(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $transHistory = new TransactionHistorySell();
        $transDetail = new TransactionDetailSell();

        if (auth()->user()->user_position == "reseller") {
            // RESELLER JUAL = RESELLER DAN DISTRIBUTOR DAPAT POIN
            $idDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            $data = [
                'transaction_code' => $request->transactionCode,
                'id_group' => auth()->user()->id_group,
                'id_distributor' => $idDistributor->id,
                'id_owner' => auth()->user()->id,
                'id_input' => auth()->user()->id,
                'nama_input' => auth()->user()->firstname . " " . auth()->user()->lastname,
                'jumlah_barang' => $request->jumlahBarang,
                'tanggal_pesan' => date("Y-m-d"),
                'jam_pesan' => date("h:i:sa"),
                'diskon' => $request->diskon,
                'keterangan_diskon' => $request->keterangan_diskon,
                'total' => $request->total,
                'status_pesanan' => 1,
                'nama_pembeli' => $request->nama_pembeli,
                'metode_pembayaran' => $request->metode_pembayaran,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $transHistory->DBaddHistorySell($data);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Create transaksi '" . $data['transaction_code'] . "'";
            UserHistory::create($newActivity);

            $lastId = TransactionHistorySell::orderBy('id', 'DESC')->first();
            $lastId = $lastId->id;

            $dataBarang = $request->cart;

            $total_crm_poin_distributor = 0;
            $total_crm_poin_reseller = 0;

            for ($i = 0; $i < count($dataBarang); $i++) {
                $produk = Product::where('id', $dataBarang[$i][4])->first();
                $crm_poin = CrmPoin::where('id_productType', $produk->id_productType)->first();

                $detail = [
                    'id_transaction' => $lastId,
                    'nama_produk' => $dataBarang[$i][0],
                    'jumlah' => $dataBarang[$i][1],
                    'harga' => $dataBarang[$i][2],
                    'total' => $dataBarang[$i][3],
                    'id_product' => $dataBarang[$i][4],
                    'crm_poin_distributor' => $crm_poin->distributor_reseller_jual * $dataBarang[$i][1],
                    'crm_poin_reseller' => $crm_poin->reseller_jual * $dataBarang[$i][1],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $transDetail->DBaddDetailsSell($detail);

                $product = Product::where('id', $dataBarang[$i][4])->first();
                $jumlahStok = $product->stok - $dataBarang[$i][1];
                $product->stok = $jumlahStok;
                $product->save();

                $total_crm_poin_distributor += $crm_poin->distributor_reseller_jual * $dataBarang[$i][1];
                $total_crm_poin_reseller += $crm_poin->reseller_jual * $dataBarang[$i][1];
            }

            $dist = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $dist->update(array('crm_poin' => $total_crm_poin_distributor + $dist->crm_poin));
            $res = User::where('id', auth()->user()->id)->first();
            $res->update(array('crm_poin' => $total_crm_poin_reseller + $res->crm_poin));

            $transaksi = TransactionHistorySell::latest()->first();
            $transaksi->update(array('total_crm_poin_distributor' => $total_crm_poin_distributor));
            $transaksi->update(array('total_crm_poin_reseller' => $total_crm_poin_reseller));

            return response()->json(["code" => "sukses"]);
        } else {
            // DISTRIBUTOR JUAL = DIST DAPET POIN
            $idDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $idOwner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            $data = [
                'transaction_code' => $request->transactionCode,
                'id_group' => auth()->user()->id_group,
                'id_distributor' => $idDistributor->id,
                'id_owner' => $idOwner->id,
                'id_input' => auth()->user()->id,
                'nama_pembeli' => $request->nama_pembeli,
                'nama_input' => auth()->user()->firstname . " " . auth()->user()->lastname,
                'jumlah_barang' => $request->jumlahBarang,
                'tanggal_pesan' => date("Y-m-d"),
                'jam_pesan' => date("h:i:sa"),
                'diskon' => $request->diskon,
                'keterangan_diskon' => $request->keterangan_diskon,
                'total' => $request->total,
                'status_pesanan' => 1,
                'metode_pembayaran' => $request->metode_pembayaran,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $transHistory->DBaddHistorySell($data);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Create transaksi '" . $data['transaction_code'] . "'";
            UserHistory::create($newActivity);

            $lastId = TransactionHistorySell::orderBy('id', 'DESC')->first();
            $lastId = $lastId->id;

            $dataBarang = $request->cart;

            $total_crm_poin_distributor = 0;
            for ($i = 0; $i < count($dataBarang); $i++) {
                $produk = Product::where('id', $dataBarang[$i][4])->first();
                $crm_poin = CrmPoin::where('id_productType', $produk->id_productType)->first();

                $detail = [
                    'id_transaction' => $lastId,
                    'nama_produk' => $dataBarang[$i][0],
                    'jumlah' => $dataBarang[$i][1],
                    'harga' => $dataBarang[$i][2],
                    'total' => $dataBarang[$i][3],
                    'id_product' => $dataBarang[$i][4],
                    'crm_poin_distributor' => $crm_poin->distributor_jual * $dataBarang[$i][1],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $transDetail->DBaddDetailsSell($detail);

                $product = Product::where('id', $dataBarang[$i][4])->first();
                $jumlahStok = $product->stok - $dataBarang[$i][1];
                $product->stok = $jumlahStok;
                $product->save();

                $total_crm_poin_distributor += $crm_poin->distributor_jual * $dataBarang[$i][1];
            }

            $dist = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $dist->update(array('crm_poin' => $total_crm_poin_distributor + $dist->crm_poin));
            $transaksi = TransactionHistorySell::latest()->first();
            $transaksi->update(array('total_crm_poin_distributor' => $total_crm_poin_distributor));

            return response()->json(["code" => "sukses"]);
        }
    }

    public function getHistorySell()
    {

        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->select('*')->get();
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $direct = url('/manage_transaction/transaction_history_sell/printDetail/' . $history->id);
            $output .= '
            <tr>
                <td>' . $history->transaction_code . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td>' . number_format($history->diskon, 0, ',', '.') . '</td>
                <td>' . $history->keterangan_diskon . '</td>
                <td>' . $history->tanggal_pesan . '</td>
                <td>' . $history->metode_pembayaran . '</td>
                <td>
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit"></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#tr' . $ctr . '" aria-expanded="false" aria-controls="tr' . $ctr . '">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="collapse" id="tr' . $ctr . '">
                <td colspan="7">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm text-left">
                            
                            <p style="font-size:12px;color:grey;font-weight:500"></p>	
                        </div>
                        <div class="col-sm text-right">
                            <p>Jumlah Barang : ' . $history->jumlah_barang . '</p>
                        </div>
                    </div>
                    <table class="table table-hover table-light">
                        <tbody>';

            $details = TransactionDetailSell::where('id_transaction', $history->id)->select('*')->get();
            $ctr1 = 1;
            foreach ($details as $detail) {
                $output .= '
                            <tr>
                                <td class="align-middle">' . $ctr1 . '</td>
                                <td class="align-middle">' . $detail->nama_produk . '</td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                        <p style="font-weight:500;">' . $detail->jumlah . ' pcs</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->harga, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->total, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                            </tr>';
                $ctr1++;
            }

            $output .= '                   
                    </tbody>
                    </table>
                </td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
            </tr>
                ';
            $ctr++;
        }
        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function getHistoryDate(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();
        // $from = date_create($request->min);
        // $to = date_create($request->max);
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->id_distributor != 1) {
                $distributor = User::where('id_group', $history->id_group)->where('user_position', 'superadmin_distributor')->first();
                $disName = $distributor->username;
            } else {
                $disName = "Pabrik";
            }

            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $direct = url('/manage_transaction/transaction_history/printDetail/' . $history->id);
            $output .= '
            <tr>
                <td>' . $history->transaction_code . '</td>
                <td>' . $disName . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td>' . $status . '</td>
                <td>' . $history->updated_at->format('d/m/y H:i:s') . '</td>
                <td>' . $history->metode_pembayaran . '</td>
                <td>
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit"></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#tr' . $ctr . '" aria-expanded="false" aria-controls="tr' . $ctr . '">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="collapse" id="tr' . $ctr . '">
                <td colspan="7">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm text-left">
                            
                            <p style="font-size:12px;color:grey;font-weight:500"></p>	
                        </div>
                        <div class="col-sm text-right">
                            <p>Jumlah Barang : ' . $history->jumlah_barang . '</p>
                        </div>
                    </div>
                    <table class="table table-hover table-light">
                        <tbody>';

            $details = TransactionDetail::where('id_transaction', $history->id)->select('*')->get();
            $ctr1 = 1;
            foreach ($details as $detail) {
                $output .= '
                            <tr>
                                <td class="align-middle">' . $ctr1 . '</td>
                                <td class="align-middle">' . $detail->nama_produk . '</td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                        <p style="font-weight:500;">' . $detail->jumlah . ' pcs</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->harga, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->total, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                            </tr>';
                $ctr1++;
            }

            $output .= '                   
                    </tbody>
                    </table>
                </td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>

            </tr>
                ';
            $ctr++;
        }
        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function getHistorySellDate(Request $request)
    {
        $from = date_create($request->min);
        $to = date_create($request->max);

        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Keterangan</th>                   
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereBetween('tanggal_pesan', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereDate('tanggal_pesan', '<', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereDate('tanggal_pesan', '>', $from)->select('*')->get();
            }
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereBetween('tanggal_pesan', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('tanggal_pesan', '<', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('tanggal_pesan', '>', $from)->select('*')->get();
            }
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $direct = url('/manage_transaction/transaction_history_sell/printDetail/' . $history->id);
            $output .= '
            <tr>
                <td>' . $history->transaction_code . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td>' . number_format($history->diskon, 0, ',', '.') . '</td>
                <td>' . $history->keterangan_diskon . '</td>
                <td>' . $history->tanggal_pesan . '</td>
                <td>' . $history->metode_pembayaran . '</td>
                <td>
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit"></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#tr' . $ctr . '" aria-expanded="false" aria-controls="tr' . $ctr . '">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>

            <tr class="collapse" id="tr' . $ctr . '">
                <td colspan="7">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-sm text-left">
                            
                            <p style="font-size:12px;color:grey;font-weight:500"></p>	
                        </div>
                        <div class="col-sm text-right">
                            <p>Jumlah Barang : ' . $history->jumlah_barang . '</p>
                        </div>
                    </div>
                    <table class="table table-hover table-light">
                        <tbody>';

            $details = TransactionDetailSell::where('id_transaction', $history->id)->select('*')->get();
            $ctr1 = 1;
            foreach ($details as $detail) {
                $output .= '
                            <tr>
                                <td class="align-middle">' . $ctr1 . '</td>
                                <td class="align-middle">' . $detail->nama_produk . '</td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                        <p style="font-weight:500;">' . $detail->jumlah . ' pcs</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->harga, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="col-sm text-left">
                                        <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                        <p style="font-weight:500;">Rp. ' . number_format($detail->total, 0, ',', '.') . '</p>	
                                    </div>
                                </td>
                            </tr>';
                $ctr1++;
            }

            $output .= '                   
                    </tbody>
                    </table>
                </td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>
                <td style="padding:0px"></td>

            </tr>
                ';
            $ctr++;
        }
        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function print($id)
    {
        return view('manage_transactions.print_riwayat_transaksi');
    }

    public function printSell($id)
    {
        return view('manage_transactions.print_riwayat_transaksi_jual');
    }

    public function printDetail($id)
    {
        return view('manage_transactions.print_detail_transaksi', [
            'id' => $id
        ]);
    }

    public function printDetailSell($id)
    {
        return view('manage_transactions.print_detail_transaksi_jual', [
            'id' => $id
        ]);
    }

    public function getHistoryPrint()
    {
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal</th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            $histories = TransactionHistory::where('id_owner', auth()->user()->id)->select('*')->get();
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->id_distributor != 1) {
                $distributor = User::where('id_group', $history->id_group)->where('user_position', 'superadmin_distributor')->first();
                $disName = $distributor->username;
            } else {
                $disName = "Pabrik";
            }

            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $output .= '
            <tr>
                <td>' . $history->transaction_code . '</td>
                <td>' . $disName . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td>' . $status . '</td>
                <td>' . $history->tanggal_pesan . '</td>
            </tr>';
        }
        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function getHistorySellPrint()
    {
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->select('*')->get();
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $output .= '
            <tr>
                <td>' . $history->transaction_code . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td>' . number_format($history->diskon, 0, ',', '.') . '</td>
                <td>' . $history->keterangan_diskon . '</td>
                <td>' . $history->tanggal_pesan . '</td>
            </tr>';
        }
        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function getHistoryDetailPrint(Request $request)
    {
        $details = TransactionDetail::where('id_transaction', $request->id)->select('*')->get();
        $output = '
        <table class="table table-hover table-light">
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-sm text-right">
                                <p>Jumlah Barang : ' . count($details) . '</p>
                            </div>
                        </div>
                        <table class="table table-hover table-light">
                            <tbody>';


        $ctr1 = 1;
        foreach ($details as $detail) {
            $output .= '
                        <tr>
                            <td class="align-middle">' . $ctr1 . '</td>
                            <td class="align-middle">' . $detail->nama_produk . '</td>
                            <td class="align-middle">
                                <div class="col-sm text-left">
                                    <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                    <p style="font-weight:500;">' . $detail->jumlah . ' pcs</p>	
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="col-sm text-left">
                                    <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                    <p style="font-weight:500;">Rp. ' . number_format($detail->harga, 0, ',', '.') . '</p>	
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="col-sm text-left">
                                    <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                    <p style="font-weight:500;">Rp. ' . number_format($detail->total, 0, ',', '.') . '</p>	
                                </div>
                            </td>
                        </tr>';
            $ctr1++;
        }

        $output .= "
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>";

        return $output;
    }

    public function getHistorySellDetailPrint(Request $request)
    {
        $details = TransactionDetailSell::where('id_transaction', $request->id)->select('*')->get();
        $output = '
        <table class="table table-hover table-light">
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-sm text-right">
                                <p>Jumlah Barang : ' . count($details) . '</p>
                            </div>
                        </div>
                        <table class="table table-hover table-light">
                            <tbody>';


        $ctr1 = 1;
        foreach ($details as $detail) {
            $output .= '
                        <tr>
                            <td class="align-middle">' . $ctr1 . '</td>
                            <td class="align-middle">' . $detail->nama_produk . '</td>
                            <td class="align-middle">
                                <div class="col-sm text-left">
                                    <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                    <p style="font-weight:500;">' . $detail->jumlah . ' pcs</p>	
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="col-sm text-left">
                                    <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                    <p style="font-weight:500;">Rp. ' . number_format($detail->harga, 0, ',', '.') . '</p>	
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="col-sm text-left">
                                    <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                    <p style="font-weight:500;">Rp. ' . number_format($detail->total, 0, ',', '.') . '</p>	
                                </div>
                            </td>
                        </tr>';
            $ctr1++;
        }

        $output .= "
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>";

        return $output;
    }

    public function getHistoryPrintData(Request $request)
    {
        $historyData = TransactionHistory::where('id', $request->id)->select('*')->get();
        $user = User::where('id', $historyData[0]->id_distributor)->select("*")->get();
        return [$historyData, $user];
    }

    public function getHistorySellPrintData(Request $request)
    {
        $historyData = TransactionHistorySell::where('id', $request->id)->select('*')->get();
        $user = User::where('id', $historyData[0]->id_distributor)->select("*")->get();
        return [$historyData, $user];
    }

    // NEW ====================================================
    public function viewBuyHistory()
    {
        if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistory::where('id_owner', $owner->id)->get();
            $details = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $owner->id)->select('transaction_details.*')->get();
            return view('manage_transactions.buy.history', compact(['owner', 'histories', 'details']));
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $histories = TransactionHistory::where('id_owner', $owner->id)->get();
            $details = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $owner->id)->select('transaction_details.*')->get();
            return view('manage_transactions.buy.history', compact(['owner', 'histories', 'details']));
        }
    }

    public function getDateBuyHistory(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();
        // $from = date_create($request->min);
        // $to = date_create($request->max);
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistory::where('id_owner', auth()->user()->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
        }
        $ctr = 1;
        foreach ($histories as $history) {
            if ($history->id_distributor != 1) {
                $distributor = User::where('id_group', $history->id_group)->where('user_position', 'superadmin_distributor')->first();
                $disName = $distributor->username;
            } else {
                $disName = "Pabrik";
            }

            if ($history->status_pesanan == 0) {
                $status = "Menunggu Konfirmasi";
            } else
                $status = "Sukses";

            $output .= '
            <tr id="' . $history->id . '">
                <td>' . $history->transaction_code . '</td>
                <td>' . $disName . '</td>
                <td>Rp. ' . number_format($history->total, 0, ',', '.') . '</td>
                <td class="col-1">' . $status . '</td>
                <td>' . $history->updated_at->format('d/m/y H:i:s') . '</td>
                <td>' . $history->metode_pembayaran . '</td>
                <td class="col-2">
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . url("/manage_transaction/buy/history/print_detail/" . $history->id) . '`)">
                            <span><i class="fa fa-edit"></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link carousel" onclick="functionDetail(' . $history->id . ')">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>
                ';
            $ctr++;
        }
        $output .= '</tbody>
        </table>
        <br>
        <h4>Total : Rp. <span id="totalAll"></span></h4>';
        return response()->json($output);
    }

    public function printBuyHistory(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        // dd($request->min);
        if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
            return view('manage_transactions.buy.print_history', compact(['owner', 'histories']));
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $histories = TransactionHistory::where('id_owner', $owner->id)->get();

            return view('manage_transactions.buy.print_history', compact(['owner', 'histories']));
        }
    }

    public function printDetailBuyHistory($id_history)
    {
        $history = TransactionHistory::where('id', $id_history)->first();
        $details = TransactionDetail::where('id_transaction', $history->id)->get();

        return view('manage_transactions.buy.print_detail', compact(['history', 'details']));
    }

    public function viewSellHistory()
    {
        if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            // Distributor
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistorySell::where('id_owner', $owner->id)->get();
            $details = TransactionDetailSell::query()
                ->join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')
                ->join('product_types as pt', 'pt.nama_produk', '=', 'transaction_detail_sells.nama_produk')
                ->join('products as p', 'p.id_productType', '=', 'pt.id')
                ->where('transaction_history_sells.id_owner', $owner->id)
                ->select('transaction_detail_sells.*', 'p.lokasi_barang')->get();

            return view('manage_transactions.sell.history', compact(['owner', 'histories', 'details']));
        } else if (auth()->user()->user_position == "reseller") {
            // Resller
            $owner = auth()->user();
            $histories = TransactionHistorySell::where('id_owner', $owner->id)->get();
            $details = TransactionDetailSell::query()
                ->join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')
                ->join('product_types as pt', 'pt.nama_produk', '=', 'transaction_detail_sells.nama_produk')
                ->join('products as p', 'p.id_productType', '=', 'pt.id')
                ->where('transaction_history_sells.id_owner', $owner->id)
                ->select('transaction_detail_sells.*', 'p.lokasi_barang')->get();

            return view('manage_transactions.sell.history', compact(['owner', 'histories', 'details']));
        }
    }

    public function getDateSellHistory(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();
        // $from = date_create($request->min);
        // $to = date_create($request->max);
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->user_position == "reseller") {
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
        } else {
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $distributor->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
        }
        $ctr = 1;
        foreach ($histories as $history) {

            $output .= '
            <tr id="' . $history->id . '">
                <td>' . $history->transaction_code . '</td>
                <td>' . number_format($history->total, 0, ',', '.') . '</td>
                <td>Rp. ' . number_format($history->diskon, 0, ',', '.') . '</td>
                <td>' . $history->keterangan_diskon . '</td>
                <td>' . $history->updated_at->format('d/m/y H:i:s') . '</td>
                <td>' . $history->metode_pembayaran . '</td>
                <td class="col-2">
                    <div class="col text-left">
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . url("/manage_transaction/sell/history/print_detail/" . $history->id) . '`)">
                            <span><i class="fa fa-edit"></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link carousel" onclick="functionDetail(' . $history->id . ')">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>
                ';
            $ctr++;
        }
        $output .= '</tbody>
        </table>
        <br>
        <h4>Total : Rp. <span id="totalAll"></span></h4>';

        return response()->json($output);
    }

    public function printSellHistory(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
            return view('manage_transactions.sell.print_history', compact(['owner', 'histories']));
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            if ($request->min != "" && $request->max != "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereBetween('updated_at', [$from, $to])->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->select('*')->get();
            } else if ($request->min == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereDate('updated_at', '<=', $to)->select('*')->get();
            } else if ($request->max == "") {
                $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->whereDate('updated_at', '>=', $from)->select('*')->get();
            }
            return view('manage_transactions.sell.print_history', compact(['owner', 'histories']));
        }
    }

    public function printDetailSellHistory($id_history)
    {
        $history = TransactionHistorySell::where('id', $id_history)->first();
        $details = TransactionDetailSell::where('id_transaction', $history->id)->get();

        return view('manage_transactions.sell.print_detail', compact(['history', 'details']));
    }

    //  IMPORT TRANSACTION PUSAT
    public function importTransaction(Request $request)
    {
        try {
            Excel::import(new TransactionImport(), $request->file('import_excel'));
            return redirect('/manage_transaction/buy/history');
        } catch (NoTypeDetectedException $e) {
            flash("Import failed")->error();
            return back();
        }
    }

    //  IMPORT TRANSACTION KASIR
    public function importTransactionSell(Request $request)
    {
        try {
            Excel::import(new TransactionSellImport(), $request->file('import_excel'));
            return redirect('/manage_transaction/sell/history');
        } catch (NoTypeDetectedException $e) {
            flash("Import failed")->error();
            return back();
        }
    }

    public function exportBuyHistory()
    {
        if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->get();

            $pdf = PDF::loadView('manage_transactions.buy.export', compact(['owner', 'histories']));
            return $pdf->download('Riwayat Transaksi Beli - ' . date('F Y') . '.pdf');
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $histories = TransactionHistory::where('id_owner', $owner->id)->get();

            $pdf = PDF::loadView('manage_transactions.buy.export', compact(['owner', 'histories']));
            return $pdf->download('Riwayat Transaksi Beli - ' . date('F Y') . '.pdf');
        }
    }


    public function exportSellHistory()
    {
        if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            // Distributor
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistorySell::where('id_owner', $owner->id)->get();
            $details = TransactionDetailSell::query()
                ->join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')
                ->join('product_types as pt', 'pt.nama_produk', '=', 'transaction_detail_sells.nama_produk')
                ->join('products as p', 'p.id_productType', '=', 'pt.id')
                ->where('transaction_history_sells.id_owner', $owner->id)
                ->select('transaction_detail_sells.*', 'p.lokasi_barang')->get();

            $pdf = PDF::loadView('manage_transactions.sell.export', compact(['owner', 'histories', 'details']));
            return $pdf->download('Riwayat Transaksi Jual - ' . date('F Y') . '.pdf');
        } else if (auth()->user()->user_position == "reseller") {
            // Resller
            $owner = auth()->user();
            $histories = TransactionHistorySell::where('id_owner', $owner->id)->get();
            $details = TransactionDetailSell::query()
                ->join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')
                ->join('product_types as pt', 'pt.nama_produk', '=', 'transaction_detail_sells.nama_produk')
                ->join('products as p', 'p.id_productType', '=', 'pt.id')
                ->where('transaction_history_sells.id_owner', $owner->id)
                ->select('transaction_detail_sells.*', 'p.lokasi_barang')->get();

            $pdf = PDF::loadView('manage_transactions.sell.export', compact(['owner', 'histories', 'details']));
            return $pdf->download('Riwayat Transaksi Jual - ' . date('F Y') . '.pdf');
        }
    }
}
