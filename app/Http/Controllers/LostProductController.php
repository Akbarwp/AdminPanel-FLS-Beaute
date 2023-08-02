<?php

namespace App\Http\Controllers;

use App\Models\LostProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Session;
use PDF;

class LostProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->user_position == "superadmin_pabrik") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $lost_products = LostProduct::where('id_owner', $owner->id)->get();
            return view('lost_product.index[1]', compact('lost_products'));
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $lost_products = LostProduct::where('id_owner', $owner->id)->get();
            return view('lost_product.index[1]', compact('lost_products'));
        }
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->user_position == "superadmin_pabrik") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $products = Product::where('id_owner', $owner->id)->get();
            return view('lost_product.create', compact('products'));
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $products = Product::where('id_owner', $owner->id)->get();
            return view('lost_product.create', compact('products'));
        }
        return back();
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
            'id_product' => 'required',
            'stok_real' => 'required',
            'stok_sisa' => 'required',
            'stok_hilang' => 'required',
            'total_kerugian' => 'required',
        ]);

        $produk = Product::where('id', $validateData['id_product'])->first();
        $validateData['nama_produk'] = $produk->product_type->nama_produk;
        $validateData['harga_modal'] = $produk->harga_modal;

        if (auth()->user()->user_position == "superadmin_pabrik") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
        }
        $validateData['id_owner'] = $owner->id;
        $validateData['id_input'] = auth()->user()->id;
        $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;
        LostProduct::create($validateData);

        $produk->update(array('stok' => $validateData['stok_sisa']));

        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "create barang '" . $validateData['nama_produk'] . "' hilang " . $validateData['stok_hilang'] . " pcs";
        UserHistory::create($newActivity);

        Session::flash('create_success', 'Data barang hilang berhasil ditambahkan');
        return redirect('/report_product/lostproducts/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LostProduct  $lostProduct
     * @return \Illuminate\Http\Response
     */
    public function show(LostProduct $lostProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LostProduct  $lostProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(LostProduct $lostProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LostProduct  $lostProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LostProduct $lostProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LostProduct  $lostProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(LostProduct $lostProduct)
    {
        //
    }

    public function print()
    {
        if (auth()->user()->user_position == "superadmin_pabrik") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $lost_products = LostProduct::where('id_owner', $owner->id)->get();
            return view('lost_product.print', compact('lost_products'));
            
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $lost_products = LostProduct::where('id_owner', $owner->id)->get();
            return view('lost_product.print', compact('lost_products'));

        }
    }

    public function export()
    {
        if (auth()->user()->user_position == "superadmin_pabrik") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $lost_products = LostProduct::where('id_owner', $owner->id)->get();
    
            $pdf = PDF::loadView('lost_product.export', compact('lost_products'));
            return $pdf->download('Daftar Barang Hilang - ' . date('F Y') . '.pdf');
        
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $lost_products = LostProduct::where('id_owner', $owner->id)->get();

            $pdf = PDF::loadView('lost_product.export', compact('lost_products'));
            return $pdf->download('Daftar Barang Hilang - ' . date('F Y') . '.pdf');
        
        }
    }

    public function printDetail($id)
    {
        $lost_product = LostProduct::where('id', $id)->first();
        return view('lost_product.printDetail', compact('lost_product'));
    }
}
