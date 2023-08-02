<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SalesProduct;
use Illuminate\Support\Facades\Session;
use App\Models\UserHistory;
use PDF;

class ManageAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_position == 'superadmin_pabrik')
        {
            $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->orWhere('user_position', 'superadmin_distributor')->get();
            return view('manage_account.index', compact(['users']));
        }
        // else if(auth()->user()->id_group == 1)
        // {
        //     $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->where('user_position', '!=', 'superadmin_pabrik')->orWhere('user_position', 'superadmin_distributor')->get();

        //     // $admins = User::where('user_position', 'admin')->orWhere('user_position', 'superadmin_pabrik')->get();

        //     return view('manage_account.index', compact(['users']));
        // }
        else if(auth()->user()->user_position == 'superadmin_distributor')
        {
            $users = User::where('id_group',auth()->user()->id_group)->get();
            return view('manage_account.index', compact('users'));
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
        if(auth()->user()->user_position == "superadmin_pabrik")
        {
            $user = auth()->user();
            $provinces = Province::all();
            $checkAdmin = (User::where('user_position', 'admin')->count() < 3) ? true : false;
            $checkAccounting = (User::where('user_position', 'accounting_pabrik')->count() < 1) ? true : false;
            $checkCashier = (User::where('user_position', 'cashier_pabrik')->count() < 3) ? true : false;

            return view('manage_account.create', compact(['user', 'provinces', 'checkAdmin', 'checkAccounting', 'checkCashier']));
        }
        else if(auth()->user()->user_position == "superadmin_distributor")
        {
            $user = auth()->user();
            $provinces = Province::all();
            $checkAccounting = (User::where('id_group', auth()->user()->id_group)->where('user_position', 'accounting_distributor')->count() < 1) ? true : false;
            $checkCashier = (User::where('id_group', auth()->user()->id_group)->where('user_position', 'cashier_distributor')->count() < 3) ? true : false;

            return view('manage_account.create', compact(['user', 'provinces', 'checkAccounting', 'checkCashier']));
        }
        return back();
        // return view('manage_account.create', ['user' => auth()->user()], ['provinces' => Province::all()]);
    }
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('province_id',$request->province_id)->get(["id", "name"]);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->user_position === "superadmin_pabrik" || auth()->user()->user_position === "superadmin_distributor")
        {
            if(auth()->user()->user_position === "superadmin_distributor")
            {
                $validateData = $request->validate([
                    'user_position' => 'required',
                    'username' => 'required|min:3|max:255|unique:users',
                    'image' => 'image|file|max:1024',
                    'firstname' => 'required|max:255',
                    'lastname' => 'required|max:255',
                    'ktp' => 'required|digits:16|unique:users',
                    'no_hp' => 'required',
                    'email' => 'required|email:dns|unique:users',
                    'province_id' => 'required',
                    'city_id' => 'required',
                    'address' => 'required',
                    'postcode' => 'required|digits:5',
                ]);
                $validateData['id_group'] = auth()->user()->id_group;        
            }
            else if(auth()->user()->user_position === "superadmin_pabrik")
            {   
                if($request->user_position == "superadmin_distributor")
                {
                    $validateData = $request->validate([
                        'user_position' => 'required',
                        'username' => 'required|min:3|max:255|unique:users',
                        'image' => 'image|file|max:1024',
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'ktp' => 'required|digits:16|unique:users',
                        'no_hp' => 'required',
                        'email' => 'required|email:dns|unique:users',
                        'province_id' => 'required',
                        'city_id' => 'required',
                        'address' => 'required',
                        'postcode' => 'required|digits:5',
                        // 'cluster' => 'required',
                    ]);
                }
                else
                {
                    $validateData = $request->validate([
                        'user_position' => 'required',
                        'username' => 'required|min:3|max:255|unique:users',
                        'image' => 'image|file|max:1024',
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'ktp' => 'required|digits:16|unique:users',
                        'no_hp' => 'required',
                        'email' => 'required|email:dns|unique:users',
                        'province_id' => 'required',
                        'city_id' => 'required',
                        'address' => 'required',
                        'postcode' => 'required|digits:5',
                    ]);
                }
    
                if($validateData['user_position'] != "superadmin_distributor")
                {
                    $validateData['id_group'] = auth()->user()->id_group;        
                }
                else
                {
                    $groupdata['nama_group'] = $validateData['username'];
                    Group::create($groupdata);
    
                    $validateData['id_group'] = Group::latest()->first()->id;    
                }
    
                // if($validateData['user_position'] == "superadmin_distributor")
                // {
                //     $validateData['cluster'] = $request->cluster;
                // }
            }
    
            if($request->file('image'))
            {
                $validateData['image'] = $request->file('image')->store('/manage_account/users');
            }
    
            $validateData['password'] = Hash::make($request->password);
    
            $validateData['id_input'] = auth()->user()->id;
            $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;
    
            if(!$request->password)
            {
                $validateData['password'] = Hash::make("12345");
            }
    
            // if($request->tokopedia){
            //     $validateData['tokopedia'] = $request->tokopedialink;
            // }
            // if($request->shopee){
            //     $validateData['shopee'] = $request->shopeelink;
            // }
            // if($request->lazada){
            //     $validateData['lazada'] = $request->lazadalink;
            // }
            // if($request->bukalapak){
            //     $validateData['bukalapak'] = $request->bukalapaklink;
            // }
            // if($request->blibli){
            //     $validateData['blibli'] = $request->bliblilink;
            // }
    
// SETTING PERMISSION DEFAULT
            if($validateData['user_position'] == "admin")
            {
                $validateData['lihat_barang'] = 1;
                $validateData['edit_barang'] = 1;
                $validateData['hapus_barang'] = 1;
                $validateData['pasok_barang'] = 1;
                $validateData['acc_transaksi'] = 1;
                $validateData['lihat_laporan_penjualan'] = 1;
                $validateData['lihat_laporan_retur_penjualan'] = 1;
            }
            else if($validateData['user_position'] == "accounting_pabrik")
            {
                // BELUM
            }
            else if($validateData['user_position'] == "cashier_pabrik")
            {
                $validateData['lihat_barang'] = 1;
                $validateData['pasok_barang'] = 1;
                $validateData['acc_transaksi'] = 1;
            }
            else if($validateData['user_position'] == "superadmin_distributor")
            {
                $validateData['lihat_barang'] = 1;
                $validateData['edit_barang'] = 1;
                
                $validateData['lihat_tracking_sales'] = 1;
                $validateData['lihat_crm'] = 1;

                $validateData['lihat_pos'] = 1;
                $validateData['input_pos'] = 1;
                $validateData['acc_transaksi'] = 1;

                $validateData['input_retur'] = 1;
                $validateData['acc_retur'] = 1;

                $validateData['lihat_laporan_penjualan'] = 1;
                $validateData['lihat_laporan_pembelian'] = 1;
                $validateData['lihat_laporan_pegawai'] = 1;
                $validateData['lihat_laporan_retur_penjualan'] = 1;
                $validateData['lihat_laporan_retur_pembelian'] = 1;
            }
            else if($validateData['user_position'] == "accounting_distributor")
            {
                $validateData['lihat_barang'] = 1;

                $validateData['lihat_pos'] = 1;
                $validateData['input_pos'] = 1;

                // accounting belum
            }
            else if($validateData['user_position'] == "cashier_distributor")
            {
                $validateData['lihat_barang'] = 1;
                
                $validateData['lihat_pos'] = 1;
                $validateData['input_pos'] = 1;
                $validateData['acc_transaksi'] = 1;
            }
            else if($validateData['user_position'] == "reseller")
            {
                $validateData['lihat_barang'] = 1;
                $validateData['edit_barang'] = 1;

                $validateData['lihat_pos'] = 1;
                $validateData['input_pos'] = 1;

                $validateData['lihat_crm'] = 1;

                $validateData['input_retur'] = 1;
                $validateData['acc_retur'] = 1;

                $validateData['lihat_laporan_penjualan'] = 1;
                $validateData['lihat_laporan_pembelian'] = 1;
                $validateData['lihat_laporan_retur_penjualan'] = 1;
                $validateData['lihat_laporan_retur_pembelian'] = 1;
            }
            else if($validateData['user_position'] == "sales")
            {
                $validateData['lihat_tracking_sales'] = 1;
                $validateData['lihat_crm'] = 1;

                $validateData['input_retur'] = 1;

                $validateData['lihat_laporan_penjualan'] = 1;
            }

            User::create($validateData);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Create akun '". $validateData['firstname']. " " . $validateData['lastname']."'";
            UserHistory::create($newActivity);


// MEMBUAT PRODUK APABILA SUPERADMIN_PABRIK MEMBUAT USER - SUPERADMIN_DISTRIBUTOR
            if($validateData['user_position'] == "superadmin_distributor")
            {
                $distributor = User::latest()->first();
                $types = ProductType::all();
                $produk = Product::distinct()->select('id_productType', 'id_category')->get();
                foreach($types as $value => $type)
                {
                    $newProduct['id_category'] = $produk[$value]->id_category;
                    $newProduct['id_productType'] = $type->id;
                    $newProduct['id_group'] = $distributor->id_group;
                    $newProduct['id_owner'] = $distributor->id;
                    $newProduct['stok'] = 0;
                    $newProduct['harga_jual'] = 0;

                    $productPusat = Product::where('id_productType', $type->id)->where('id_group',1)->first();
                    $newProduct['harga_modal'] = $productPusat->harga_jual;
                    $newProduct['keterangan'] = 'Kosong';

                    Product::create($newProduct);

                    $salesProduct['id_productType'] = $type->id;
                    $salesProduct['id_group'] = $distributor->id_group;
                    $salesProduct['id_owner'] = $distributor->id;
                    $salesProduct['harga_jual'] = 0;
                    $salesProduct['bonus'] = 0;

                    SalesProduct::create($salesProduct);
                }
                Session::flash('create_success', 'Akun distributor berhasil dibuat');
                return redirect('/manage_account/users');
            }

// MEMBUAT PRODUK APABILA SUPERADMIN_DISTRIBUTOR MEMBUAT USER - RESELLER
            if($validateData['user_position'] == "reseller")
            {
                $reseller = User::latest()->first();
                $types = ProductType::all();
                $produk = Product::distinct()->select('id_productType', 'id_category')->get();
                foreach($types as $value => $type)
                {
                    $newProduct['id_category'] = $produk[$value]->id_category;
                    $newProduct['id_productType'] = $type->id;
                    $newProduct['id_group'] = $reseller->id_group;
                    $newProduct['id_owner'] = $reseller->id;
                    $newProduct['stok'] = 0;
                    $newProduct['harga_jual'] = 0;

                    $productPusat = Product::where('id_productType', $type->id)->where('id_group',$reseller->id_group)->first();
                    $newProduct['harga_modal'] = $productPusat->harga_jual;
                    $newProduct['keterangan'] = 'Kosong';

                    Product::create($newProduct);
                }
                Session::flash('create_success', 'Akun reseller berhasil dibuat');
                return redirect('/manage_account/users');
            }

// MEMBUAT PRODUK APABILA SUPERADMIN_DISTRIBUTOR MEMBUAT USER - SALES
            if($validateData['user_position'] == "sales")
            {
                $sales = User::latest()->first();
                $types = ProductType::all();
                foreach($types as $type)
                {
                    $salesProduct = SalesProduct::where('id_productType', $type->id)->where('id_group',$sales->id_group)->first();

                    $newProduct['id_productType'] = $type->id;
                    $newProduct['id_group'] = $sales->id_group;
                    $newProduct['id_owner'] = $sales->id;
                    $newProduct['stok'] = 0;
                    $newProduct['harga_jual'] = $salesProduct->harga_jual;
                    $newProduct['bonus_penjualan'] = $salesProduct->bonus;

                    $productPusat = Product::where('id_productType', $type->id)->where('id_group',1)->first();
                    $newProduct['harga_modal'] = $productPusat->harga_jual;
                    $newProduct['keterangan'] = 'Kosong';

                    Product::create($newProduct);
                }
                Session::flash('create_success', 'Akun sales berhasil dibuat');
                return redirect('/manage_account/users');
            }
            
            Session::flash('create_success', 'Akun pegawai berhasil dibuat');
            return redirect('/manage_account/users');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userHistories = UserHistory::where('id_user', $user->id)->get();
        return view('manage_account.history', compact(['userHistories', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(auth()->user()->user_position == "superadmin_pabrik" || auth()->user()->user_position == "admin")
        {
            $provinces = Province::all();
            $checkAdmin = (User::where('user_position', 'admin')->count() < 3 || $user->user_position == 'admin') ? true : false;
            $checkAccounting = (User::where('user_position', 'accounting_pabrik')->count() < 1 || $user->user_position == 'accounting_pabrik') ? true : false;
            $checkCashier = (User::where('user_position', 'cashier_pabrik')->count() < 3 || $user->user_position == 'cashier_pabrik') ? true : false;

            return view('manage_account.edit', compact(['user', 'provinces', 'checkAdmin', 'checkAccounting', 'checkCashier']));
        }
        else if(auth()->user()->user_position == "superadmin_distributor")
        {
            $provinces = Province::all();
            $checkAccounting = (User::where('id_group', auth()->user()->id_group)->where('user_position', 'accounting_distributor')->count() < 1 || $user->user_position == 'accounting_distributor') ? true : false;
            $checkCashier = (User::where('id_group', auth()->user()->id_group)->where('user_position', 'cashier_distributor')->count() < 3 || $user->user_position == 'cashier_distributor') ? true : false;

            return view('manage_account.edit', compact(['user', 'provinces', 'checkAccounting', 'checkCashier']));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(auth()->user()->user_position === "superadmin_distributor")
        {
            if($user->user_position == "superadmin_distributor")
            {
                $rules = [
                    'image' => 'image|file|max:1024',
                    'firstname' => 'required|max:255',
                    'lastname' => 'required|max:255',
                    'province_id' => 'required',
                    'city_id' => 'required',
                    'address' => 'required',
                    'postcode' => 'required|digits:5',
                ];
            }
            else
            {
                $rules = [
                    'user_position' => 'required',
                    'image' => 'image|file|max:1024',
                    'firstname' => 'required|max:255',
                    'lastname' => 'required|max:255',
                    'province_id' => 'required',
                    'city_id' => 'required',
                    'address' => 'required',
                    'postcode' => 'required|digits:5',
                ];
            }
            
            if($request->username != $user->username) {
                $rules['username'] = 'required|min:3|max:255|unique:users';
            }
            if($request->ktp != $user->ktp) {
                $rules['ktp'] = 'required|digits:16|unique:users';
            }
            if($request->email != $user->email) {
                $rules['email'] = 'required|email:dns|unique:users';
            }
            $validateData = $request->validate($rules);
        }
        else
        {   
            if($request->user_position == "superadmin_distributor")
            {
                $rules = [
                    'user_position' => 'required',
                    'image' => 'image|file|max:1024',
                    'firstname' => 'required|max:255',
                    'lastname' => 'required|max:255',
                    'province_id' => 'required',
                    'city_id' => 'required',
                    'address' => 'required',
                    'postcode' => 'required|digits:5',
                    // 'cluster' => 'required',
                ];
                if($request->username != $user->username) {
                    $rules['username'] = 'required|min:3|max:255|unique:users';
                }
                if($request->ktp != $user->ktp) {
                    $rules['ktp'] = 'required|digits:16|unique:users';
                }
                if($request->email != $user->email) {
                    $rules['email'] = 'required|email:dns|unique:users';
                }
                $validateData = $request->validate($rules);
            }
            else
            {
                if($user->user_position == "superadmin_pabrik")
                {
                    $rules = [
                        'image' => 'image|file|max:1024',
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'province_id' => 'required',
                        'city_id' => 'required',
                        'address' => 'required',
                        'postcode' => 'required|digits:5',
                    ];
                }
                else
                {
                    $rules = [
                        'user_position' => 'required',
                        'image' => 'image|file|max:1024',
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'province_id' => 'required',
                        'city_id' => 'required',
                        'address' => 'required',
                        'postcode' => 'required|digits:5',
                    ];
                }
                
                if($request->username != $user->username) {
                    $rules['username'] = 'required|min:3|max:255|unique:users';
                }
                if($request->ktp != $user->ktp) {
                    $rules['ktp'] = 'required|digits:16|unique:users';
                }
                if($request->email != $user->email) {
                    $rules['email'] = 'required|email:dns|unique:users';
                }
                $validateData = $request->validate($rules);
            }
            

            // if($validateData['user_position'] == "superadmin_distributor")
            // {
            //     $validateData['cluster'] = $request->cluster;
            // }
        }

        // if($request->username != $user->username) {
        //     $validateData['username'] = 'required|min:3|max:255|unique:users';
        // }

        // if($request->email != $user->email) {
        //     $validateData['email'] = 'required|email:dns|unique:users';
        // }

        

        // $valid = $request->validate($validateData);

        if($request->file('image')) {
            Storage::delete($user->image);
            // kalo ada gambar baru = hapus gambar lama lalu upload yg baru
            $validateData['image'] = $request->file('image')->store('/manage_account/users');
        }
        else
        {
            if($user->image)
            {
                Storage::delete($user->image);
                $validateData['image'] = null;
            }
        }

        $validateData['id_input'] = auth()->user()->id;
        $validateData['nama_input'] = auth()->user()->firstname . " " . auth()->user()->lastname;

        if($request->password)
        {
            $validateData['password'] = Hash::make($request->password);
            // $validateData['password'] = Hash::make("12345");
        }

        if($request->tokopedia){
            $validateData['tokopedia'] = $request->tokopedialink;
        }
        else{
            $validateData['tokopedia'] = null;
        }

        if($request->shopee){
            $validateData['shopee'] = $request->shopeelink;
        }
        else{
            $validateData['shopee'] = null;
        }

        if($request->lazada){
            $validateData['lazada'] = $request->lazadalink;
        }
        else{
            $validateData['lazada'] = null;
        }

        if($request->bukalapak){
            $validateData['bukalapak'] = $request->bukalapaklink;
        }
        else{
            $validateData['bukalapak'] = null;
        }

        if($request->blibli){
            $validateData['blibli'] = $request->bliblilink;
        }
        else{
            $validateData['blibli'] = null;
        }

        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Edit akun '". $validateData['firstname']. " " . $validateData['lastname']."'";
        UserHistory::create($newActivity);

        User::where('id', $user->id)
            ->update($validateData);

        Session::flash('update_success', 'Akun berhasil diedit');
        return redirect('/manage_account/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // dd($user);
        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Delete akun '". $user->firstname. " " . $user->lastname."'";
        UserHistory::create($newActivity);

        if($user->image){
            Storage::delete($user->image);
        }

        if($user->user_position == "superadmin_distributor")
        {
            $productGroups = Product::where('id_group', $user->id_group)->get();
            foreach($productGroups as $productGroup)
            {
                Product::destroy(($productGroup->id));
            }

            $userGroups = User::where('id_group', $user->id_group)->get();
            foreach($userGroups as $userGroup)
            {
                User::destroy($userGroup->id);
            }

            Group::destroy($user->id_group);
        }
        else if($user->user_position == "reseller")
        {
            $productResellers = Product::where('id_owner', $user->id)->get();
            foreach($productResellers as $productReseller)
            {
                Product::destroy(($productReseller->id));
            }
            User::destroy($user->id);
        }
        else{
            User::destroy($user->id);
        }

        

        Session::flash('delete_success', 'Akun berhasil dihapus');
        return redirect('/manage_account/users')->with('success', 'User has been deleted!');
    }


    public function print()
    {
        if(auth()->user()->user_position == "superadmin_pabrik" || auth()->user()->user_position == "admin")
        {
            $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->orWhere('user_position', 'superadmin_distributor')->get();

            $admins = User::where('user_position', 'admin')->orWhere('user_position', 'superadmin_pabrik')->get();

            $countSuperAdminPabrik = User::where('user_position', 'superadmin_pabrik')->count();
            $countAdmin = User::where('user_position', 'admin')->count();
            $countCashierPabrik = User::where('user_position', 'cashier_pabrik')->count();
            $countAccountingPabrik = User::where('user_position', 'accounting_pabrik')->count();
            $countSuperAdminDistributor = User::where('user_position', 'superadmin_distributor')->count();
            $countProspekDistributor = User::where('user_position', 'prospek_distributor')->count();
            $countTotal = $countSuperAdminPabrik + $countAdmin + $countCashierPabrik + $countAccountingPabrik + $countSuperAdminDistributor + $countProspekDistributor;
            return view('manage_account.print', compact(['users', 'admins', 'countTotal', 'countSuperAdminPabrik', 'countAdmin', 'countCashierPabrik', 'countAccountingPabrik', 'countSuperAdminDistributor', 'countProspekDistributor']));
        }
        else if(auth()->user()->user_position == "superadmin_distributor")
        {
            $users = User::where('id_group', auth()->user()->id_group)->get();
            $countSuperAdminDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->count();
            $countCashierDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'cashier_distributor')->count();
            $countAccountingDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'accounting_distributor')->count();
            $countReseller = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->count();
            $countProspekReseller = User::where('id_group', auth()->user()->id_group)->where('user_position', 'prospek_reseller')->count();
            $countTotal = $countSuperAdminDistributor + $countCashierDistributor + $countAccountingDistributor + $countReseller + $countProspekReseller;

            return view('manage_account.print', compact(['users', 'countTotal', 'countSuperAdminDistributor', 'countCashierDistributor', 'countAccountingDistributor', 'countReseller', 'countProspekReseller']));
        }
    }

    public function export()
    {
        if(auth()->user()->user_position == "superadmin_pabrik" || auth()->user()->user_position == "admin")
        {
            $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->orWhere('user_position', 'superadmin_distributor')->get();

            $admins = User::where('user_position', 'admin')->orWhere('user_position', 'superadmin_pabrik')->get();

            $countSuperAdminPabrik = User::where('user_position', 'superadmin_pabrik')->count();
            $countAdmin = User::where('user_position', 'admin')->count();
            $countCashierPabrik = User::where('user_position', 'cashier_pabrik')->count();
            $countAccountingPabrik = User::where('user_position', 'accounting_pabrik')->count();
            $countSuperAdminDistributor = User::where('user_position', 'superadmin_distributor')->count();
            $countProspekDistributor = User::where('user_position', 'prospek_distributor')->count();
            $countTotal = $countSuperAdminPabrik + $countAdmin + $countCashierPabrik + $countAccountingPabrik + $countSuperAdminDistributor + $countProspekDistributor;

            $pdf = PDF::loadView('manage_account.export', compact(['users', 'admins', 'countTotal', 'countSuperAdminPabrik', 'countAdmin', 'countCashierPabrik', 'countAccountingPabrik', 'countSuperAdminDistributor', 'countProspekDistributor']));
            return $pdf->download('Daftar Akun - '.date('F Y').'.pdf');


        }
        else if(auth()->user()->user_position == "superadmin_distributor")
        {
            $users = User::where('id_group', auth()->user()->id_group)->get();
            $countSuperAdminDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->count();
            $countCashierDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'cashier_distributor')->count();
            $countAccountingDistributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'accounting_distributor')->count();
            $countReseller = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->count();
            $countProspekReseller = User::where('id_group', auth()->user()->id_group)->where('user_position', 'prospek_reseller')->count();
            $countTotal = $countSuperAdminDistributor + $countCashierDistributor + $countAccountingDistributor + $countReseller + $countProspekReseller;
            

            $pdf = PDF::loadView('manage_account.export', compact(['users', 'countTotal', 'countSuperAdminDistributor', 'countCashierDistributor', 'countAccountingDistributor', 'countReseller', 'countProspekReseller']));
            return $pdf->download('Daftar Akun - '.date('F Y').'.pdf');

            // return PDF::loadView('manage_account.export_distributor', compact(['users', 'countTotal', 'countSuperAdminDistributor', 'countCashierDistributor', 'countAccountingDistributor', 'countReseller', 'countProspekReseller']))->setPaper('A4')->stream();
        }
    }

    public function history()
    {
        return view('manage_account.history');
    }

    public function permission()
    {
        // return view('manage_account.permission');
        if(auth()->user()->user_position == 'superadmin_pabrik')
        {
            // $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->where('user_position', '!=', 'superadmin_distributor')->where('user_position', '!=', 'superadmin_pabrik')->get();
            $users = User::where('id_group', 1)->orWhere('user_position', '=', 'superadmin_distributor')->get();
            return view('manage_account.permission', compact('users'));
        }
        else if(auth()->user()->user_position == 'superadmin_distributor')
        {
            // $users = User::where('id_input',auth()->user()->id)->where('user_position', '!=', 'reseller')->where('user_position','!=','prospek_distributor')->get();
            $users = User::where('id_group',auth()->user()->id_group)->where('user_position','!=','prospek_distributor')->where('user_position','!=','superadmin_distributor')->get();
            return view('manage_account.permission', compact('users'));
        }
        return back();
    }

    public function changePermission($user, $access)
    {
    	$pengguna = User::where('id', $user)
    	->select($access)
    	->first();
        
    	if($pengguna->$access == 1){
    		User::where('id', $user)
            ->update([$access => 0]);
    	}else{
    		User::where('id', $user)
            ->update([$access => 1]);
    	}
    	

        if(auth()->user()->user_position == 'superadmin_pabrik')
        {
            // $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->where('user_position', '!=', 'superadmin_distributor')->where('user_position', '!=', 'superadmin_pabrik')->get();
            $users = User::where('id_group', 1)->orWhere('user_position', '=', 'superadmin_distributor')->get();
            return view('manage_account.permission', compact('users'));
        }
        else if(auth()->user()->user_position == 'superadmin_distributor')
        {
            $users = User::where('id_input',auth()->user()->id)->where('user_position', '!=', 'reseller')->where('user_position','!=','prospek_distributor')->get();
            return view('manage_account.permission', compact('users'));
        }

    }

    public function historyPrint($id_user)
    {
        $user = User::where('id', $id_user)->first();
        $userHistories = UserHistory::where('id_user', $user->id)->get();
        return view('manage_account.printHistory', compact(['user', 'userHistories']));
    }

    public function historyExport($id_user)
    {
        $user = User::where('id', $id_user)->first();
        $userHistories = UserHistory::where('id_user', $user->id)->get();

        $pdf = PDF::loadView('manage_account.exportHistory', compact(['user', 'userHistories']));
        return $pdf->download('History '.$user->firstname.' '.$user->lastname.' - '.date('F Y').'.pdf');
    }
    public function print_permission(){
        if(auth()->user()->user_position == 'superadmin_pabrik')
        {
            // $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->where('user_position', '!=', 'superadmin_distributor')->where('user_position', '!=', 'superadmin_pabrik')->get();
            $users = User::where('id_group', 1)->orWhere('user_position', '=', 'superadmin_distributor')->get();
            return view('manage_account.printPermission', compact('users'));
        }
        else if(auth()->user()->user_position == 'superadmin_distributor')
        {
            // $users = User::where('id_input',auth()->user()->id)->where('user_position', '!=', 'reseller')->where('user_position','!=','prospek_distributor')->get();
            $users = User::where('id_group',auth()->user()->id_group)->where('user_position','!=','prospek_distributor')->where('user_position','!=','superadmin_distributor')->get();
            return view('manage_account.printPermission', compact('users'));
        }
    }

    public function export_permission(){
        if(auth()->user()->user_position == 'superadmin_pabrik')
        {
            $users = User::where('id_group', 1)->orWhere('user_position', '=', 'superadmin_distributor')->get();
        }
        else if(auth()->user()->user_position == 'superadmin_distributor')
        {
            // $users = User::where('id_input',auth()->user()->id)->where('user_position', '!=', 'reseller')->where('user_position','!=','prospek_distributor')->get();
            $users = User::where('id_group',auth()->user()->id_group)->where('user_position','!=','prospek_distributor')->where('user_position','!=','superadmin_distributor')->get();
        }

        $pdf = PDF::loadView('manage_account.exportPermission', compact(['users']));
        return $pdf->download('Permission - '.date('F Y').'.pdf');
    }

    public function sidebarRefresh()
    {
    	return view('templates.sidebar');
    }
}
