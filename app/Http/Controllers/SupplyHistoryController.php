<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\SupplyDetail;
use App\Models\SupplyHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserHistory;
use PDF;

class SupplyHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(SupplyHistory::join('products', 'products.id', '=', 'supply_histories.id_product')->groupBy('kode_pasok')->select('supply_histories.*')->selectRaw('sum(jumlah*harga_modal) as total')->get());
        // dd(SupplyDetail::join('supply_histories','supply_histories.id','=','supply_details.id_supply'))
        // return view('manage_product.input_supply.index', ['histories_group' => SupplyHistory::join('products', 'products.id', '=', 'supply_histories.id_product')->groupBy('kode_pasok')->select('supply_histories.*')->selectRaw('sum(jumlah*harga_modal) as total')->get()], ['superadmins' => User::where('user_position', 'superadmin_pabrik')->orWhere('user_position', 'admin')->orWhere('user_position', 'cashier_pabrik')->get()]);

        $histories = SupplyHistory::all();
        return view('manage_product.input_supply.index', compact('histories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(Product::where('id_group',auth()->user()->id_group)->get());
        return view('manage_product.input_supply.create', ['products' => Product::where('id_group', auth()->user()->id_group)->get()], ['types' => ProductType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $validateData = $request->validate([
            'kode_pasok' => 'required|unique:supply_histories',
            'surat_jalan' => 'required|unique:supply_histories',
            'metode_pembayaran' => 'required',
        ]);

        $validateData['nama_supplier'] = 'pabrik fls';
        $validateData['id_input'] = auth()->user()->id;
        $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;

        $length = (count($request->all()) - 4) / 3;
        // -4 = token, kode_pasok, surat_jalan, metode_pembayaran

        SupplyHistory::create($validateData);
        $validateDetail['id_supply'] = SupplyHistory::latest()->first()->id;

        $totalSupply = 0;
        for ($i = 1; $i <= $length; $i++) {
            if ($request->input("id_product" . $i) && $request->input("jumlah" . $i)) {
                $produk = Product::where('id', $request->input("id_product" . $i))->first();
                $validateDetail['id_product'] = $produk->id;
                $validateDetail['nama_produk'] = $produk->product_type->nama_produk;
                $validateDetail['jumlah'] = (int)$request->input("jumlah" . $i);
                $validateDetail['harga'] = (int)$produk->harga_modal;
                $validateDetail['total'] = $validateDetail['jumlah'] * $validateDetail['harga'];

                SupplyDetail::create($validateDetail);

                $totalSupply += $validateDetail['total'];
                $stok = Product::where('id', $request->input("id_product" . $i))->first();
                $updateStok = $stok->stok + $validateDetail['jumlah'];
                Product::where('id', $request->input("id_product" . $i))->update(array('stok' => $updateStok));
                if ($updateStok > 0) {
                    $keteranganStok = 'Tersedia';
                } else {
                    $keteranganStok = 'Kosong';
                }
                Product::where('id', $request->input("id_product" . $i))->update(array('keterangan' => $keteranganStok));
            }
        }

        SupplyHistory::where('id', $validateDetail['id_supply'])->update(array('total' => $totalSupply));


        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Input pasok '" . $validateData['kode_pasok'] . "'";
        UserHistory::create($newActivity);

        Session::flash('create_success', 'Input pasok berhasil ditambahkan');
        return redirect('/manage_product/input_pasok/supplyhistories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplyHistory  $supplyHistory
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyHistory $supplyHistory)
    {
        // dd($supplyHistory);
    }

    public function detail($id_supply)
    {
        // dd($kode_pasok);
        $history =  SupplyHistory::where('id', $id_supply)->first();
        $details = SupplyDetail::where('id_supply', $history->id)->get();
        return view('manage_product.input_supply.detail', compact(['history', 'details']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplyHistory  $supplyHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplyHistory $supplyHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplyHistory  $supplyHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplyHistory $supplyHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplyHistory  $supplyHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplyHistory $supplyHistory)
    {
        //
    }

    public function print()
    {
        $histories = SupplyHistory::all();
        // $histories_group = SupplyHistory::join('products', 'products.id', '=', 'supply_histories.id_product')->groupBy('kode_pasok')->select('supply_histories.*')->selectRaw('sum(jumlah*harga_modal) as total')->get();
        // $superadmins = User::where('user_position', 'superadmin_pabrik')->orWhere('user_position', 'admin')->orWhere('user_position', 'cashier_pabrik')->get();
        return view('manage_product.input_supply.print', compact(['histories']));
    }

    public function export()
    {
        // $histories_group = SupplyHistory::join('products', 'products.id', '=', 'supply_histories.id_product')->groupBy('kode_pasok')->select('supply_histories.*')->selectRaw('sum(jumlah*harga_modal) as total')->get();
        // $superadmins = User::where('user_position', 'superadmin_pabrik')->orWhere('user_position', 'admin')->orWhere('user_position', 'cashier_pabrik')->get();

        $histories = SupplyHistory::all();

        $pdf = PDF::loadView('manage_product.input_supply.export', compact(['histories']));
        return $pdf->download('Daftar Input Pasok Barang - ' . date('j F Y') . '.pdf');
    }

    public function printDetail($id_supply)
    {
        $history =  SupplyHistory::where('id', $id_supply)->first();
        $details = SupplyDetail::where('id_supply', $history->id)->get();

        return view("manage_product.input_supply.print_detail_pasok", compact(['history', 'details']));
    }

    public function exportDetail($id_supply)
    {
        $history =  SupplyHistory::where('id', $id_supply)->first();
        $details = SupplyDetail::where('id_supply', $history->id)->get();

        $pdf = PDF::loadView('manage_product.input_supply.export_detail_pasok', compact(['history', 'details']));
        return $pdf->download('Detail History Pasok - ' . $history->kode_pasok . ' - ' . date('j F Y') . '.pdf');
    }
}
