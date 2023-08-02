<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ReturHistory;
use App\Models\SupplyHistory;
use Illuminate\Http\Request;
use App\Models\SupplyDetail;
use App\Models\User;
use App\Models\ReturDetail;
use App\Models\SalesStokDetail;
use App\Models\SalesStokHistory;
use App\Models\TransactionDetail;
use App\Models\TransactionHistory;
use App\Models\UserHistory;
use App\Imports\ReturImport;
use App\Imports\ReturCashierMainImport;
use App\Exports\ReturExport;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use PDF;

class ReturController extends Controller
{
    public function indexReturSupplier()
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            } else if (auth()->user()->user_position == "reseller" || auth()->user()->user_position == "sales") {
                $owner = auth()->user();
            }
            $returs = ReturHistory::where('id_owner', $owner->id)->get();
            return view('retur.supplier.index', compact('returs'));
        }

        return back();
    }

    public function createReturSupplier()
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                $transactions = TransactionHistory::where('id_owner', $owner->id)->where('status_pesanan', 1)->get();
                return view('retur.supplier.create', compact('transactions'));
            } else if (auth()->user()->user_position == "reseller") {
                $transactions = TransactionHistory::where('id_owner', auth()->user()->id)->where('status_pesanan', 1)->get();
                return view('retur.supplier.create', compact('transactions'));
            } else if (auth()->user()->user_position == "sales") {
                $transactions = SalesStokHistory::where('id_owner', auth()->user()->id)->where('status', 1)->get();
                return view('retur.supplier.create', compact('transactions'));
            }
        }
        return back();
    }

    public function getDetails($id)
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->user_position != "sales") {
            $transaction = TransactionHistory::where('id', $id)->first();
            $supplier = User::where('id', $transaction->id_distributor)->first();
            $namaSupplier = $supplier->firstname . " " . $supplier->lastname;
            $tanggalTransaksi = $transaction->created_at->format('d/m/y H:i:s');
            $details = TransactionDetail::where('id_transaction', $transaction->id)->get();

            $list = '';
            $count = 1;
            foreach ($details as $detail) {
                $list .= '
                <tr>
                    <td><div class="form-check"><input class="form-check-input" type="checkbox" name="check' . $count . '" id=""></div></td>
                    <td><input value="' . $detail->id_product . '" name="id_product' . $count . '" hidden>' . $detail->nama_produk . '</input></td>
                    <td>' . $detail->jumlah . '</td>
                    <td>Rp. ' . $detail->harga . '</td>
                    <td>Rp. ' . $detail->total . '</td>
                    <td><input type="number" class="form-control" name="jumlah' . $count . '" min="0" max="' . $detail->jumlah . '"></input></td>
                    <td scope="col">
                        <img src="' . asset('images/astanalogo.jpg') . '" alt="profile-img" class="img-fluid img-preview' . $count . '" width="50%"/>
                        <p id="file-name' . $count . '">aaa</p>
                        <label for="file-upload' . $count . '" class="custom-file-upload upload btn-primary d-flex justify-content-center align-items-center">
                        <p>Upload Foto</p>
                        </label>
                        <input class="form-control" id="file-upload' . $count . '" name="image' . $count . '" type="file" hidden="" onchange="previewImage(' . $count . ')"/>
                    </td>
                </tr>';
                $count++;
            }

            $count--;
            $list .= '<input value="' . $count . '" name="count" hidden></input>';

            return response()->json(compact(['namaSupplier', 'tanggalTransaksi', 'list']));
        } else if (auth()->user()->input_retur == 1 && auth()->user()->user_position == "sales") {
            $transaction = SalesStokHistory::where('id', $id)->first();
            $supplier = User::where('id', $transaction->id_distributor)->first();
            $namaSupplier = $supplier->firstname . " " . $supplier->lastname;
            $tanggalTransaksi = $transaction->updated_at->format('d/m/y H:i:s');
            $details = SalesStokDetail::where('id_sales_stok', $transaction->id)->get();

            $list = '';
            $count = 1;
            foreach ($details as $detail) {
                $list .= '
                <tr>
                    <td><div class="form-check"><input class="form-check-input" type="checkbox" name="check' . $count . '" id=""></div></td>
                    <td><input value="' . $detail->id_product . '" name="id_product' . $count . '" hidden>' . $detail->nama_produk . '</input></td>
                    <td>' . $detail->jumlah . '</td>
                    <td>Rp. ' . $detail->harga_jual . '</td>
                    <td>Rp. ' . $detail->total . '</td>
                    <td><input type="number" class="form-control" name="jumlah' . $count . '" min="0" max="' . $detail->jumlah . '"></input></td>
                    <td scope="col">
                        <img src="' . asset('images/astanalogo.jpg') . '" alt="profile-img" class="img-fluid img-preview' . $count . '" width="50%"/>
                        <p id="file-name' . $count . '">aaa</p>
                        <label for="file-upload' . $count . '" class="custom-file-upload upload btn-primary d-flex justify-content-center align-items-center">
                        <p>Upload Foto</p>
                        </label>
                        <input class="form-control" id="file-upload' . $count . '" name="image' . $count . '" type="file" hidden="" onchange="previewImage(' . $count . ')"/>
                    </td>
                </tr>';
                $count++;
            }

            $count--;
            $list .= '<input value="' . $count . '" name="count" hidden></input>';

            return response()->json(compact(['namaSupplier', 'tanggalTransaksi', 'list']));
        }

        return back();
    }

    public function storeReturSupplier(Request $request)
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->user_position != "sales") {
            if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            } else if (auth()->user()->user_position == "reseller") {
                $owner = auth()->user();
            }

            $stok_tersedia = true;
            $list = "";

            for ($i = 1; $i <= $request->count; $i++) {
                if ($request->input("check" . $i) && $request->input("jumlah" . $i)) {
                    $produkSupplier = Product::where('id', $request->input("id_product" . $i))->first();
                    $produk = Product::where('id_productType', $produkSupplier->id_productType)->where('id_owner', $owner->id)->first();

                    if ($request->input("jumlah" . $i) > $produk->stok) {
                        $stok_tersedia = false;
                        $list .= " *";
                        $list .= $produk->product_type->nama_produk;
                    }
                } else {
                    Session::flash('create_retur_failed', 'Please centang dan masukkan produk yang akan di Retur !');
                    return back();
                }
            }

            if ($stok_tersedia) {
                $randomNumber = random_int(100000, 999999);
                $validateData = $request->validate([
                    'id_transaction' => 'required',
                    'keterangan' => 'required',
                ]);
                $validateData['id_group'] = auth()->user()->id_group;
                $transaction = TransactionHistory::where('id', $validateData['id_transaction'])->first();
                $supplier = User::where('id', $transaction->id_distributor)->first();
                $validateData['id_supplier'] = $supplier->id;

                $validateData['id_owner'] = $owner->id;
                $validateData['id_input'] = auth()->user()->id;
                $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;
                $validateData['surat_keluar'] = "SK" . $randomNumber;
                $validateData['status_retur'] = 0;

                ReturHistory::create($validateData);

                $validateDetail['id_retur'] = ReturHistory::latest()->first()->id;

                $jumlahBarang = 0;
                $totalRetur = 0;
                for ($i = 1; $i <= $request->count; $i++) {
                    if ($request->input("check" . $i) && $request->input("jumlah" . $i)) {
                        $produkSupplier = Product::where('id', $request->input("id_product" . $i))->first();
                        $produk = Product::where('id_productType', $produkSupplier->id_productType)->where('id_owner', $owner->id)->first();

                        $validateDetail['id_product'] = $produk->id;

                        $validateDetail['nama_produk'] = $produk->product_type->nama_produk;
                        $validateDetail['jumlah'] = $request->input("jumlah" . $i);
                        $validateDetail['harga'] = $produk->harga_modal;
                        $validateDetail['total'] = $validateDetail['jumlah'] * $validateDetail['harga'];

                        if ($request->file('image' . $i)) {
                            $temp = 'image' . $i;
                            $validateDetail['foto'] = $request->file($temp)->store('/retur/bukti_retur');
                        }

                        ReturDetail::create($validateDetail);

                        $jumlahBarang++;
                        $totalRetur += $validateDetail['total'];
                    }
                }

                $history = ReturHistory::where('id', $validateDetail['id_retur'])->first();
                $history->update(array('jumlah_barang' => $jumlahBarang));
                $history->update(array('total' => $totalRetur));

                $returs = ReturHistory::where('id_owner', $owner->id)->get();

                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $newActivity['kegiatan'] = "Create Retur '" . $history->surat_keluar . "'";
                UserHistory::create($newActivity);

                Session::flash('create_retur_success', 'Retur berhasil ditambahkan');
                return view('retur.supplier.index', compact('returs'));
            } else {
                Session::flash('create_retur_failed', 'stok produk :' . $list . ' kurang');
                return back();
            }
        } else if (auth()->user()->input_retur == 1 && auth()->user()->user_position == "sales") {
            $owner = auth()->user();
            $stok_tersedia = true;
            $list = "";

            for ($i = 1; $i <= $request->count; $i++) {
                if ($request->input("check" . $i) && $request->input("jumlah" . $i)) {
                    $produk = Product::where('id', $request->input("id_product" . $i))->first();

                    if ($request->input("jumlah" . $i) > $produk->stok) {
                        $stok_tersedia = false;
                        $list .= " *";
                        $list .= $produk->product_type->nama_produk;
                    }
                } else {
                    return back();
                }
            }

            if ($stok_tersedia) {
                $randomNumber = random_int(100000, 999999);
                $validateData = $request->validate([
                    'id_transaction' => 'required',
                    'keterangan' => 'required',
                ]);
                $validateData['id_group'] = auth()->user()->id_group;
                $transaction = SalesStokHistory::where('id', $validateData['id_transaction'])->first();
                $supplier = User::where('id', $transaction->id_distributor)->first();
                $validateData['id_supplier'] = $supplier->id;

                $validateData['id_owner'] = $owner->id;
                $validateData['id_input'] = auth()->user()->id;
                $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;
                $validateData['surat_keluar'] = "SK" . $randomNumber;
                $validateData['status_retur'] = 0;

                ReturHistory::create($validateData);

                $validateDetail['id_retur'] = ReturHistory::latest()->first()->id;

                $jumlahBarang = 0;
                $totalRetur = 0;
                for ($i = 1; $i <= $request->count; $i++) {
                    if ($request->input("check" . $i) && $request->input("jumlah" . $i)) {
                        $produk = Product::where('id', $request->input("id_product" . $i))->first();

                        $validateDetail['id_product'] = $produk->id;

                        $validateDetail['nama_produk'] = $produk->product_type->nama_produk;
                        $validateDetail['jumlah'] = $request->input("jumlah" . $i);
                        $validateDetail['harga'] = $produk->harga_jual;
                        $validateDetail['total'] = $validateDetail['jumlah'] * $validateDetail['harga'];

                        if ($request->file('image' . $i)) {
                            $temp = 'image' . $i;
                            $validateDetail['foto'] = $request->file($temp)->store('/retur/bukti_retur');
                        }

                        ReturDetail::create($validateDetail);

                        $jumlahBarang++;
                        $totalRetur += $validateDetail['total'];
                    }
                }

                $history = ReturHistory::where('id', $validateDetail['id_retur'])->first();
                $history->update(array('jumlah_barang' => $jumlahBarang));
                $history->update(array('total' => $totalRetur));

                $returs = ReturHistory::where('id_owner', $owner->id)->get();

                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $newActivity['kegiatan'] = "Create Retur '" . $history->surat_keluar . "'";
                UserHistory::create($newActivity);

                Session::flash('create_retur_success', 'Retur berhasil ditambahkan');
                return view('retur.cashier.index', compact('returs'));
            } else {
                Session::flash('create_retur_failed', 'stok produk :' . $list . ' kurang');
                return back();
            }
        }

        return back();
    }

    public function detailReturSupplier($id_retur)
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            $retur = ReturHistory::where('id', $id_retur)->first();
            $details = ReturDetail::where('id_retur', $id_retur)->get();
            return view('retur.supplier.detail', compact('retur', 'details'));
        }

        return back();
    }

    public function printReturSupplier()
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            } else if (auth()->user()->user_position == "reseller") {
                $owner = auth()->user();
            }

            $returs = ReturHistory::where('id_owner', $owner->id)->get();
            return view('retur.supplier.print', compact('returs'));
        }

        return back();
    }

    public function exportReturSupplier()
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            } else if (auth()->user()->user_position == "reseller") {
                $owner = auth()->user();
            }

            $returs = ReturHistory::where('id_owner', $owner->id)->get();
            $pdf = PDF::loadView('retur.supplier.export', compact('returs'));
            return $pdf->download('Daftar Retur - ' . date('F Y') . '.pdf');
        }

        return back();
    }

    public function printDetailReturSupplier($id_retur)
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            $retur = ReturHistory::where('id', $id_retur)->first();
            $details = ReturDetail::where('id_retur', $id_retur)->get();

            return view('retur.supplier.printDetail', compact(['retur', 'details']));
        }

        return back();
    }

    public function exportDetailReturSupplier($id_retur)
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            $retur = ReturHistory::where('id', $id_retur)->first();
            $details = ReturDetail::where('id_retur', $id_retur)->get();

            $pdf = PDF::loadView('retur.supplier.exportDetail', compact(['retur', 'details']));
            return $pdf->download('Detail Retur - ' . date('F Y') . '.pdf');
        }

        return back();
    }

    //Import retur
    public function importRetur(Request $request)
    {
        try {
            Excel::import(new ReturImport(), $request->file('import_excel'));
            return redirect('/retur/to_supplier');
        } catch (NoTypeDetectedException $e) {
            flash("Import failed")->error();
            return back();
        }
    }
}
