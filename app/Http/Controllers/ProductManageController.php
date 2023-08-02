<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LostProduct;
use App\Models\CrmPoin;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\ProductType;
use App\Models\ReturDetail;
use App\Models\SalesProduct;
use App\Models\SalesStokDetail;
use App\Models\SalesStokHistory;
use App\Models\SupplyDetail;
use App\Models\SupplyHistory;
use App\Models\TrackingSalesDetail;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Models\UserHistory;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailSell;
use Exception;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Imports\ProductsImport;
use App\Exports\ProductListExport;
use App\Exports\ProductSecondExport;
use App\Exports\ProductExport;
use App\Exports\ProductDetailExport;
use App\Exports\ProductDetailSecondExport;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;


class ProductManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function filterTable($category, $sort)
    {
        // dd(Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', auth()->user()->id_group)->where('user_position', auth()->user()->user_position)->join('product_types', 'product_types.id', '=', 'products.id_productType')->select('product_types.*','products.*')->get());

        // dd("a");
        // if($category == 'kode_produk' || $category == 'nama_produk')
        // {

        // }
        if (auth()->user()->user_position == "superadmin_pabrik" || auth()->user()->user_position == "superadmin_distributor" || auth()->user()->user_position == "superadmin_distributor") {
            // return view('manage_product.table_view', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', auth()->user()->id_group)->where('user_position', auth()->user()->user_position)->select('products.*')->orderBy($category, $sort)->get()]);

            return view('manage_product.table_view', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', auth()->user()->id_group)->where('user_position', auth()->user()->user_position)->join('product_types', 'product_types.id', '=', 'products.id_productType')->select('product_types.*', 'products.*')->orderBy($category, $sort)->get()]);
        } else if (auth()->user()->user_position == "reseller") {
            return view('manage_product.main.index', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_owner', auth()->user()->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->select('product_types.*', 'products.*')->orderBy($category, $sort)->get()]);
        }
    }

    public function index()
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
                $products = Product::with('category')->where('id_owner', $owner->id)->get();
                return view('manage_product.main.index', compact(['owner', 'products']));
                // return view('manage_product.main.index', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->select('products.*')->get()]);
            } else if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                $products = Product::with('category')->where('id_owner', $owner->id)->get();

                return view('manage_product.main.index', compact(['owner', 'products']));
                // return view('manage_product.main.index', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->select('products.*')->get()]);
            } else {
                $owner = auth()->user();
                $products = Product::with('category')->where('id_owner', $owner->id)->get();

                return view('manage_product.main.index', compact(['owner', 'products']));
                // return view('manage_product.main.index', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_owner', auth()->user()->id)->select('products.*')->get()]);
            }
        }
        return back();
    }

    public function indexSecond()
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
                return view('manage_product.second.index', compact('lists'));
            } else if (auth()->user()->user_position != "reseller") {
                $lists = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->get();
                return view('manage_product.second.index', compact('lists'));
            }
        }
        return back();
    }

    public function indexThird()
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $distributors = User::where('user_position', 'superadmin_distributor')->get();
                return view('manage_product.third.index', compact('distributors'));
            } else {
                $username = auth()->user()->firstname . ' ' . auth()->user()->lastname;
                $distributors =
                    User::where('user_position', 'reseller')->where('nama_input', $username)->get();
                return view('manage_product.third.index', compact('distributors'));
            }
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
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group = 1) {
                $types = ProductType::all();
                $categories = Category::all();
                return view('manage_product.main.create', compact('types', 'categories'));
            }
        }
        return back();
        // return view('manage_product.create', ['types' => ProductType::all()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  SUPERADMIN_PABRIK MENAMBAH PRODUK BARU
    public function store(Request $request)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group = 1) {
                $checkType = ProductType::where('kode_produk', $request->kode_produk)->count();

                if ($checkType == 0) {
                    $newType['kode_produk'] = $request->kode_produk;
                    $newType['nama_produk'] = $request->nama_produk;
                    // $newType['jenis_barang'] = $request->jenis_barang;
                    // $newType['kualitas_barang'] = $request->kualitas_barang;

                    ProductType::create($newType);

                    $groups = User::groupBy('id_group')->get();
                    // dd($groups);
                    foreach ($groups as $group) {
                        $newProduct['id_productType'] = ProductType::latest()->first()->id;
                        $newProduct['id_group'] = $group->id_group;
                        $newProduct['lokasi_barang'] = "";

                        $owner = User::where('id_group', $group->id_group)->first();
                        $newProduct['id_owner'] = $owner->id;

                        // CREATE NEW PRODUCT PUSAT
                        if ($group->group->nama_group == "pusat") {
                            $newProduct['id_category'] = $request->id_category;
                            $newProduct['stok'] = $request->stok;
                            $newProduct['harga_jual'] = $request->harga_jual;
                            $newProduct['harga_modal'] = $request->harga_modal;
                            if ($request->stok == null || $request->stok == 0) {
                                $newProduct['keterangan'] = 'Kosong';
                            } else {
                                $newProduct['keterangan'] = 'Tersedia';
                            }
                        }
                        // CREATE NEW PRODUCT DISTRIBUTOR, HARGA MODAL = HARGA JUAL PUSAT
                        else if ($owner->user_position == "superadmin_distributor") {
                            $newProduct['id_category'] = $request->id_category;
                            $newProduct['stok'] = 0;
                            $newProduct['harga_jual'] = 0;
                            $newProduct['harga_modal'] = $request->harga_jual;
                            $newProduct['keterangan'] = 'Kosong';

                            $salesProduct['id_productType'] = $newProduct['id_productType'];
                            $salesProduct['id_group'] = $newProduct['id_group'];
                            $salesProduct['id_owner'] = $newProduct['id_owner'];
                            $salesProduct['harga_jual'] = 0;
                            $salesProduct['bonus'] = 0;

                            SalesProduct::create($salesProduct);
                        }

                        Product::create($newProduct);

                        $resellers = User::where('id_group', $owner->id_group)->where('user_position', 'reseller')->get();
                        // dd($resellers);

                        // CREATE NEW PRODUCT RESELLER, HARGA MODAL = 0
                        foreach ($resellers as $reseller) {
                            $newProductReseller['id_productType'] = ProductType::latest()->first()->id;
                            $newProductReseller['id_category'] = $request->id_category;
                            $newProductReseller['id_group'] = $owner->id_group;
                            $newProductReseller['id_owner'] = $reseller->id;
                            $newProductReseller['stok'] = 0;
                            $newProductReseller['harga_jual'] = 0;
                            $newProductReseller['harga_modal'] = 0;
                            $newProductReseller['keterangan'] = 'Kosong';

                            Product::create($newProductReseller);
                        }

                        // CREATE NEW PRODUCT SALES, HARGA MODAL = HARGA JUAL PUSAT
                        $sales = User::where('id_group', $owner->id_group)->where('user_position', 'sales')->get();

                        foreach ($sales as $s) {
                            $newProductSales['id_productType'] = ProductType::latest()->first()->id;
                            $newProductSales['id_group'] = $owner->id_group;
                            $newProductSales['id_category'] = $request->id_category;
                            $newProductSales['id_owner'] = $s->id;
                            $newProductSales['stok'] = 0;
                            $newProductSales['harga_jual'] = 0;
                            $newProductSales['harga_modal'] = $request->harga_jual;
                            $newProductSales['keterangan'] = 'Kosong';

                            Product::create($newProductSales);
                        }
                    }

                    // CREATE POIN CRM = 0
                    $newPoinCrm['id_productType'] = ProductType::latest()->first()->id;
                    $newPoinCrm['distributor_beli'] = 0;
                    $newPoinCrm['distributor_jual'] = 0;
                    $newPoinCrm['reseller_beli'] = 0;
                    CrmPoin::create($newPoinCrm);

                    $newActivity['id_user'] = auth()->user()->id;
                    $newActivity['id_group'] = auth()->user()->id_group;
                    $newActivity['kegiatan'] = "Create product '" . $request->nama_produk . "'";
                    UserHistory::create($newActivity);
                    // Session::flash('create_failed', 'aaaa'); 
                    Session::flash('create_success', 'Barang baru berhasil ditambahkan');
                    return redirect('/manage_product/products');
                } else {
                    Session::flash('create_failed', 'Kode barang telah digunakan');
                    return back();
                }
            }
        }
        return back();
    }

    //  SUPERADMIN_PABRIK IMPORT MENAMBAH PRODUK BARU
    public function importProduct(Request $request)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group = 1) {
                try {
                    Excel::import(new ProductsImport(), $request->file('import_excel'));
                    return redirect('/manage_product/products')->with('import_success', "Import Barang berhasil");
                } catch (NoTypeDetectedException $e) {
                    return back()->with('import_failed', "Gagal Barang Kategori")->error();
                }
            }
        }
        return back();
    }

    public function importCategory(Request $request)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group = 1) {
                try {
                    Excel::import(new CategoryImport(), $request->file('import_excel'));
                    return redirect('/manage_product/category')->with('import_success', "Import Kategori berhasil");
                } catch (NoTypeDetectedException $e) {
                    return back()->with('import_failed', "Gagal Import Kategori")->error();
                }
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $masuk = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->where('supply_details.id_product', $product->id)->select('supply_histories.*', 'supply_details.jumlah')->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', 1)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*', 'transaction_details.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', 1)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                // $hilang = LostProduct::where('id_owner', 1)->where('id_product', $product->id)->get();
                // return view('manage_product.main.detail', compact(['product', 'masuk', 'keluar', 'keluarRetur', 'hilang']));
                return view('manage_product.main.detail', compact(['product', 'masuk', 'keluar', 'keluarRetur']));
            } else if (auth()->user()->user_position != "reseller") {
                $produkPusat = Product::where('id_productType', $product->id_productType)->where('id_group', 1)->first();
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();

                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkPusat->id)->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*', 'transaction_details.jumlah')->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_distributor', $distributor->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*', 'transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $distributor->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                $keluarStokSales = SalesStokDetail::join('sales_stok_histories', 'sales_stok_histories.id', '=', 'sales_stok_details.id_sales_stok')->where('sales_stok_histories.id_distributor', $distributor->id)->select('sales_stok_histories.*', 'sales_stok_details.jumlah', 'sales_stok_details.id_product')->get();
                // dd($keluarStokSales);
                // $hilang = LostProduct::where('id_owner', $distributor->id)->where('id_product', $product->id)->get();
                // return view('manage_product.main.detail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur', 'hilang']));
                return view('manage_product.main.detail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur', 'keluarStokSales']));
            } else if (auth()->user()->user_position == "reseller") {
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();
                $produkDistributor = Product::where('id_productType', $product->id_productType)->where('id_owner', $distributor->id)->first();
                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', auth()->user()->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkDistributor->id)->get();
                $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', auth()->user()->id)->where('tracking_sales_details.id_produk', $product->id)->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', auth()->user()->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*', 'transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', auth()->user()->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                return view('manage_product.main.detail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
            }
        }
        return back();
    }

    public function showSecond($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id', $id)->first();
                $products = Product::where('id_owner', $id)->select('products.*')->selectRaw('stok * harga_modal as nilaiStok')->get();
                $totalStok = $products->sum('stok');
                $totalNilaiStok = $products->sum('nilaiStok');
                return view('manage_product.second.detail', compact(['owner', 'products', 'totalStok', 'totalNilaiStok']));
            }
        }

        return back();
    }

    public function showThird($user)
    {
        // dd($user);
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $distributor = User::where('id', $user)->first();
                $resellers = User::join('products', 'products.id_owner', '=', 'users.id')->where('users.id_group', $distributor->id_group)->where('user_position', 'reseller')->groupBy('products.id_owner')->select('users.*')->selectRaw('sum(stok) as stock')->get();
                $stock = Product::where('id_owner', $user)->sum('stok');
                $totalReseller = $resellers->count();
                // dd($resellers);
                return view('manage_product.third.detail', compact(['distributor', 'resellers', 'stock', 'totalReseller']));
            }
        }
        return back();
    }

    public function chartThird($user)
    {
        // dd($user);
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $reseller = User::where('id', $user)->first();
                $products = Product::where('id_owner', $user)->select('products.*')->selectRaw('stok * harga_modal as nilaiStok')->get();
                $totalStok = $products->sum('stok');
                $totalNilaiStok = $products->sum('nilaiStok');
                return view('manage_product.third.chart', compact(['reseller', 'products', 'totalStok', 'totalNilaiStok']));
            }
        }
        return back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $product = Product::with('category')->find($product);
        $categories = Category::all();
        if (auth()->user()->edit_barang == 1) {
            return view('manage_product.main.edit', compact('product', 'categories'));
        }
    }

    public function editSecond($product)
    {
        $product = Product::with('category')->find($product);
        $categories = Category::all();

        if (auth()->user()->edit_barang == 1) {
            return view('manage_product.second.editDetail', compact('product', 'categories'));
        }
    }

    public function editThird($product)
    {
        $product = Product::with('category')->find($product);
        $categories = Category::all();

        if (auth()->user()->edit_barang == 1) {
            return view('manage_product.third.edit', compact('product', 'categories'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (auth()->user()->edit_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $checkType = ProductType::where('kode_produk', $request->kode_produk)->count();
                if ($request->kode_produk == $product->product_type->kode_produk) {
                    $checkType = 0;
                }
                if ($checkType == 0) {
                    $validateData['stok'] = (int)$request->input("stok");
                    $validateData['id_category'] = $request->id_category;
                    $validateData['harga_jual'] = (int)$request->input("harga_jual");
                    $validateData['harga_modal'] = (int)$request->input("harga_modal");
                    $validateData['keterangan'] = $request->keterangan;
                    $validateData['lokasi_barang'] = $request->lokasi_barang;

                    if ($request->stok == null || $request->stok == 0) {
                        $validateData['keterangan'] = 'Kosong';
                    } else {
                        $validateData['keterangan'] = 'Tersedia';
                    }

                    // PERUBAHAN HARGA JUAL PUSAT -> HARGA MODAL DISTRIBUTOR & SALES BERUBAH
                    if (Product::where('id', $product->id)->first()->harga_jual != $validateData['harga_jual']) {
                        // dd("perubahan harga jual");
                        $productDistributors = Product::join('users', 'users.id', '=', 'products.id_owner')->where('id_productType', $product->id_productType)->where('users.user_position', 'superadmin_distributor')->select('products.*')->get();
                        // dd($productDistributor);
                        foreach ($productDistributors as $productDistributor) {
                            $productDistributor->update(array('harga_modal' => $validateData['harga_jual']));
                        }

                        $productSaless = Product::join('users', 'users.id', '=', 'products.id_owner')->where('id_productType', $product->id_productType)->where('users.user_position', 'sales')->select('products.*')->get();
                        foreach ($productSaless as $productSales) {
                            $productSales->update(array('harga_modal' => $validateData['harga_jual']));
                        }
                    }

                    $newActivity['id_user'] = auth()->user()->id;
                    $newActivity['id_group'] = auth()->user()->id_group;
                    $newActivity['kegiatan'] = "Edit product '" . Product::where('id', $product->id)->first()->product_type->nama_produk . "'";
                    UserHistory::create($newActivity);

                    Product::where('id', $product->id)->update($validateData);

                    ProductType::where('id', $product->id_productType)->update(
                        [
                            'nama_produk' => $request->nama_produk,
                            // 'jenis_barang' => $request->jenis_barang,
                            // 'lokasi_barang' => $request->lokasi_barang,
                            // 'kualitas_barang' => $request->kualitas_barang,
                        ]
                    );

                    Session::flash('update_success', 'Barang berhasil diedit');
                    return redirect('/manage_product/products');
                }
                Session::flash('update_failed', 'Kode barang telah digunakan');
                return back();
            } else if (auth()->user()->user_position != "reseller") {
                // dd("edit distributor");
                $validateData['harga_jual'] = $request->harga_jual;
                $validateData['lokasi_barang'] = $request->lokasi_barang;
                // PERUBAHAN HARGA JUAL DISTRIBUTOR -> HARGA MODAL RESELLER BERUBAH
                if (Product::where('id', $product->id)->first()->harga_jual != $validateData['harga_jual']) {
                    // dd("perubahan harga jual");
                    $productDistributor = Product::where('id', $product->id)->first();
                    $productResellers = Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', $productDistributor->id_group)->where('id_productType', $product->id_productType)->where('users.user_position', 'reseller')->select('products.*')->get();
                    // dd($productDistributor);
                    foreach ($productResellers as $productReseller) {
                        $productReseller->update(array('harga_modal' => $validateData['harga_jual']));
                    }

                    $newActivity['id_user'] = auth()->user()->id;
                    $newActivity['id_group'] = auth()->user()->id_group;
                    $newActivity['kegiatan'] = "Edit harga jual '" . $productDistributor->product_type->nama_produk . "'";
                    UserHistory::create($newActivity);
                }
                Product::where('id', $product->id)->update($validateData);
                Session::flash('update_success', 'Barang berhasil diedit');
                return redirect('/manage_product/products');
            } else if (auth()->user()->user_position == "reseller") {
                // dd("reseller");
                $validateData['harga_jual'] = $request->harga_jual;
                $validateData['lokasi_barang'] = $request->lokasi_barang;
                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $newActivity['kegiatan'] = "Edit harga jual '" . Product::where('id', $product->id)->first()->product_type->nama_produk . "'";
                UserHistory::create($newActivity);

                Product::where('id', $product->id)->update($validateData);
                Session::flash('update_success', 'Barang berhasil diedit');
                return redirect('/manage_product/products');
            }
        }
        return back();
    }

    public function updateSecond(Request $request, $product)
    {
        if (auth()->user()->edit_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $validateData['stok'] = (int)$request->input("stok");
                $validateData['harga_jual'] = (int)$request->input("harga_jual");
                $validateData['keterangan'] = $request->keterangan;

                if ($request->stok == null || $request->stok == 0) {
                    $validateData['keterangan'] = 'Kosong';
                } else {
                    $validateData['keterangan'] = 'Tersedia';
                }

                $validateData['harga_jual'] = $request->harga_jual;

                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $produk = Product::with('category')->where('id', $product)->first();
                $distributor = User::where('id', $produk->id_owner)->first();
                $newActivity['kegiatan'] = "Edit stok '" . $produk->product_type->nama_produk . "' - distributor '" . $distributor->firstname . " " . $distributor->lastname . "'";
                UserHistory::create($newActivity);

                // PERUBAHAN HARGA JUAL DISTRIBUTOR -> HARGA MODAL RESELLER BERUBAH
                if (Product::where('id', $product)->first()->harga_jual != $validateData['harga_jual']) {
                    // dd("perubahan harga jual");
                    $productDistributor = Product::with('category')->where('id', $product)->first();
                    $productResellers = Product::with('category')->join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', $productDistributor->id_group)->where('id_productType', $productDistributor->id_productType)->where('users.user_position', 'reseller')->select('products.*')->get();
                    // dd($productResellers);
                    foreach ($productResellers as $productReseller) {
                        $productReseller->update(array('harga_modal' => $validateData['harga_jual']));
                    }
                }

                Product::where('id', $product)->update($validateData);

                Session::flash('update_success', 'Barang distributor berhasil diedit');
                return redirect('/manage_product/distributor/products/' . $distributor->id);
            } else if (auth()->user()->user_position != "reseller") {
                // dd("edit reseller");
                $validateData['stok'] = (int)$request->input("stok");
                $validateData['harga_jual'] = (int)$request->input("harga_jual");
                $validateData['keterangan'] = $request->keterangan;

                if ($request->stok == null || $request->stok == 0) {
                    $validateData['keterangan'] = 'Kosong';
                } else {
                    $validateData['keterangan'] = 'Tersedia';
                }

                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $produk = Product::with('category')->where('id', $product)->first();
                $reseller = User::where('id', $produk->id_owner)->first();
                $newActivity['kegiatan'] = "Edit stok '" . $produk->product_type->nama_produk . "' - reseller '" . $reseller->firstname . " " . $reseller->lastname . "'";
                UserHistory::create($newActivity);

                Product::where('id', $product)->update($validateData);
                Session::flash('update_success', 'Barang reseller berhasil diedit');
                return redirect('/manage_product/reseller/products/' . $reseller->id);
            }
        }
        return back();
    }

    public function updateThird(Request $request, $product)
    {
        // dd($product);
        if (auth()->user()->edit_barang == 1) {
            if (auth()->user()->user_position == "superadmin_pabrik" || auth()->user()->user_position == "admin") {
                $validateData['stok'] = (int)$request->input("stok");
                $validateData['harga_jual'] = (int)$request->input("harga_jual");
                $validateData['keterangan'] = $request->keterangan;

                if ($request->stok == null || $request->stok == 0) {
                    $validateData['keterangan'] = 'Kosong';
                } else {
                    $validateData['keterangan'] = 'Tersedia';
                }

                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $produk = Product::with('category')->where('id', $product)->first();
                $reseller = User::where('id', $produk->id_owner)->first();
                $newActivity['kegiatan'] = "Edit stok '" . $produk->product_type->nama_produk . "' - reseller '" . $reseller->firstname . " " . $reseller->lastname . "'";
                UserHistory::create($newActivity);

                Product::where('id', $product)->update($validateData);

                $idOwner = Product::where('id', $product)->first()->id_owner;
                $userAccount = User::where('id', $idOwner)->first()->id;
                Session::flash('update_success', 'Barang reseller berhasil diedit');
                return redirect('/manage_product/distributor_reseller/products/chart/' . $userAccount);
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function print($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            $position = User::where('id', $id)->first()->user_position;

            if ($position == "superadmin_pabrik") {
                if (auth()->user()->id_group == 1) {
                    $pusat = User::where('id', $id)->first();
                    $products = Product::with('category')->where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
                    $types = ProductType::all();
                    $stock = Product::where('id_owner', $pusat->id)->sum('stok');

                    return view('manage_product.print', compact(['pusat', 'products', 'types', 'stock']));
                }
            } else if ($position == "superadmin_distributor") {
                if (auth()->user()->user_position != "reseller") {
                    $pusat = User::where('id', $id)->first();
                    $products = Product::with('category')->where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
                    $types = ProductType::all();
                    $stock = Product::where('id_owner', $pusat->id)->sum('stok');

                    return view('manage_product.print', compact(['pusat', 'products', 'types', 'stock']));
                }
            } else if ($position == "reseller") {
                $pusat = User::where('id', $id)->first();
                $products = Product::with('category')->where('id_owner', $id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->get();
                $types = ProductType::all();
                $stock = Product::where('id_owner', $id)->sum('stok');
                return view('manage_product.print', compact(['pusat', 'products', 'types', 'stock']));
            }
        }
    }

    public function export($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            $position = User::where('id', $id)->first()->user_position;

            if ($position == "superadmin_pabrik") {
                if (auth()->user()->id_group == 1) {
                    $pusat = User::where('id', $id)->first();
                    $products = Product::with('category')->where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
                    $types = ProductType::all();
                    $stock = Product::where('id_owner', $pusat->id)->sum('stok');

                    $pdf = PDF::loadView('manage_product.export', compact(['pusat', 'products', 'types', 'stock']));
                    return $pdf->download('Stock Barang Pusat -' . date('F Y') . '.pdf');
                }
            }
            if ($position == "superadmin_distributor") {
                if (auth()->user()->user_position != "reseller") {
                    $pusat = User::where('id', $id)->first();
                    $products = Product::with('category')->where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
                    $types = ProductType::all();
                    $stock = Product::where('id_owner', $pusat->id)->sum('stok');

                    $pdf = PDF::loadView('manage_product.export', compact(['pusat', 'products', 'types', 'stock']));
                    return $pdf->download('Stock Barang ' . $pusat->firstname . " " . $pusat->lastname . " - " . date('F Y') . '.pdf');
                }
            } else if ($position == "reseller") {
                $pusat = User::where('id', $id)->first();
                $products = Product::with('category')->where('id_owner', $id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->get();
                $types = ProductType::all();
                $stock = Product::where('id_owner', $id)->sum('stok');

                $pdf = PDF::loadView('manage_product.export', compact(['pusat', 'products', 'types', 'stock']));
                return $pdf->download('Stock Barang ' . $pusat->firstname . " " . $pusat->lastname . " - " . date('F Y') . '.pdf');
            }
        }
    }

    public function printDetail($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            $product = Product::where('id', $id)->first();
            if (auth()->user()->id_group == 1) {
                $masuk = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->where('supply_details.id_product', $product->id)->select('supply_histories.*', 'supply_details.jumlah')->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', 1)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*', 'transaction_details.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', 1)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                // $hilang = LostProduct::where('id_owner', 1)->where('id_product', $product->id)->get();
                // return view('manage_product.main.printDetail', compact(['product', 'masuk', 'keluar', 'keluarRetur', 'hilang']));
                return view('manage_product.main.printDetail', compact(['product', 'masuk', 'keluar', 'keluarRetur']));
            } else if (auth()->user()->user_position != "reseller") {
                $produkPusat = Product::with('category')->where('id_productType', $product->id_productType)->where('id_group', 1)->first();
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();

                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkPusat->id)->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*', 'transaction_details.jumlah')->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_distributor', $distributor->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*', 'transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $distributor->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                // $hilang = LostProduct::where('id_owner', $distributor->id)->where('id_product', $product->id)->get();
                // return view('manage_product.main.printDetail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur', 'hilang']));
                return view('manage_product.main.printDetail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
            } else if (auth()->user()->user_position == "reseller") {
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();
                $produkDistributor = Product::with('category')->where('id_productType', $product->id_productType)->where('id_owner', $distributor->id)->first();
                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', auth()->user()->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkDistributor->id)->get();
                $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', auth()->user()->id)->where('tracking_sales_details.id_produk', $product->id)->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', auth()->user()->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*', 'transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', auth()->user()->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                return view('manage_product.main.printDetail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
            }
        }

        return back();
    }

    public function exportDetail($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            $product = Product::where('id', $id)->first();
            if (auth()->user()->id_group == 1) {
                $masuk = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->where('supply_details.id_product', $product->id)->select('supply_histories.*', 'supply_details.jumlah')->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', 1)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*', 'transaction_details.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', 1)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                // $hilang = LostProduct::where('id_owner', 1)->where('id_product', $product->id)->get();
                // $pdf = PDF::loadView('manage_product.main.exportDetail', compact(['product', 'masuk', 'keluar', 'keluarRetur', 'hilang']));
                $pdf = PDF::loadView('manage_product.main.exportDetail', compact(['product', 'masuk', 'keluar', 'keluarRetur']));
                return $pdf->download('Daftar ' . $product->product_type->nama_produk . ' - ' . date('F Y') . '.pdf');
            } else if (auth()->user()->user_position != "reseller") {
                $produkPusat = Product::with('category')->where('id_productType', $product->id_productType)->where('id_group', 1)->first();
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();

                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkPusat->id)->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*', 'transaction_details.jumlah')->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_distributor', $distributor->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*', 'transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $distributor->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                // $hilang = LostProduct::where('id_owner', $distributor->id)->where('id_product', $product->id)->get();
                // $pdf = PDF::loadView('manage_product.main.exportDetail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur', 'hilang']));
                $pdf = PDF::loadView('manage_product.main.exportDetail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
                return $pdf->download('Daftar ' . $product->product_type->nama_produk . ' - ' . date('F Y') . '.pdf');
            } else if (auth()->user()->user_position == "reseller") {
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();
                $produkDistributor = Product::with('category')->where('id_productType', $product->id_productType)->where('id_owner', $distributor->id)->first();
                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', auth()->user()->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkDistributor->id)->get();
                $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', auth()->user()->id)->where('tracking_sales_details.id_produk', $product->id)->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', auth()->user()->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*', 'transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', auth()->user()->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*', 'retur_details.jumlah')->get();
                $pdf = PDF::loadView('manage_product.main.exportDetail', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
                return $pdf->download('Daftar ' . $product->product_type->nama_produk . ' - ' . date('F Y') . '.pdf');
            }
        }

        return back();
    }

    function printSecond()
    {
        if (auth()->user()->lihat_barang == 1) {

            if (auth()->user()->id_group == 1) {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
                return view('manage_product.second.print', compact('lists'));
            } else if (auth()->user()->user_position != "reseller") {
                $lists = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->get();
                return view('manage_product.second.print', compact('lists'));
            }
        }
        return back();
    }

    function exportSecond()
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
                $pdf = PDF::loadView('manage_product.second.export', compact('lists'));
                return $pdf->download('Daftar Distributor - ' . date('F Y') . '.pdf');
            } else if (auth()->user()->user_position != "reseller") {
                $lists = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->get();
                $pdf = PDF::loadView('manage_product.second.export', compact('lists'));
                return $pdf->download('Daftar Reseller - ' . date('F Y') . '.pdf');
            }
        }
        return back();
    }

    function printDetailSecond($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id', $id)->first();
                $products = Product::with('category')->where('id_owner', $id)->select('products.*')->selectRaw('stok * harga_modal as nilaiStok')->get();
                $totalStok = $products->sum('stok');
                $totalNilaiStok = $products->sum('nilaiStok');
                return view('manage_product.second.printDetail', compact(['owner', 'products', 'totalStok', 'totalNilaiStok']));
            }
        }

        return back();
    }

    function exportDetailSecond($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            $owner = User::where('id', $id)->first();
            $products = Product::with('category')->where('id_owner', $id)->select('products.*')->selectRaw('stok * harga_modal as nilaiStok')->get();
            $totalStok = $products->sum('stok');
            $totalNilaiStok = $products->sum('nilaiStok');

            if (auth()->user()->id_group == 1) {
                $pdf = PDF::loadView('manage_product.second.exportDetail', compact(['owner', 'products', 'totalStok', 'totalNilaiStok']));
                return $pdf->download('Daftar Barang Distributor - ' . date('F Y') . '.pdf');
            } else if (auth()->user()->user_position != "reseller") {
                $pdf = PDF::loadView('manage_product.second.exportDetail', compact(['owner', 'products', 'totalStok', 'totalNilaiStok']));
                return $pdf->download('Daftar Barang Reseller - ' . date('F Y') . '.pdf');
            }
        }
        return back();
    }


    function printThird()
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $distributors = User::where('user_position', 'superadmin_distributor')->get();
                return view('manage_product.third.print', compact('distributors'));
            }
        }
    }

    function exportThird()
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $distributors = User::where('user_position', 'superadmin_distributor')->get();
                $pdf = PDF::loadView('manage_product.third.export', compact('distributors'));
                return $pdf->download('Daftar Barang Reseller - ' . date('F Y') . '.pdf');
            }
        }
    }

    function printDetailThird($idDistributor)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $distributor = User::where('id', $idDistributor)->first();
                $resellers = User::join('products', 'products.id_owner', '=', 'users.id')->where('users.id_group', $distributor->id_group)->where('user_position', 'reseller')->groupBy('products.id_owner')->select('users.*')->selectRaw('sum(stok) as stock')->get();
                $stock = Product::where('id_owner', $idDistributor)->sum('stok');
                $totalReseller = $resellers->count();
                return view('manage_product.third.printDetail', compact(['distributor', 'resellers', 'stock', 'totalReseller']));
            }
        }
        return back();
    }

    function exportDetailThird($idDistributor)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $distributor = User::where('id', $idDistributor)->first();
                $resellers = User::join('products', 'products.id_owner', '=', 'users.id')->where('users.id_group', $distributor->id_group)->where('user_position', 'reseller')->groupBy('products.id_owner')->select('users.*')->selectRaw('sum(stok) as stock')->get();
                $stock = Product::where('id_owner', $idDistributor)->sum('stok');
                $totalReseller = $resellers->count();

                $pdf = PDF::loadView('manage_product.third.exportDetail', compact(['distributor', 'resellers', 'stock', 'totalReseller']));
                return $pdf->download('Daftar Barang Reseller - ' . date('F Y') . '.pdf');
            }
        }
        return back();
    }

    function printChartThird($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $reseller = User::where('id', $id)->first();
                $stock = Product::where('id_owner', $id)->sum('stok');
                $products = Product::with('category')->where('id_owner', $id)->get();
                $types = ProductType::all();
                return view('manage_product.third.printChart', compact(['reseller', 'stock', 'products', 'types']));
            }
        }
        return back();
    }

    function exportChartThird($id)
    {
        if (auth()->user()->lihat_barang == 1) {
            if (auth()->user()->id_group == 1) {
                $reseller = User::where('id', $id)->first();
                $stock = Product::where('id_owner', $id)->sum('stok');
                $products = Product::with('category')->where('id_owner', $id)->get();
                $types = ProductType::all();

                $pdf = PDF::loadView('manage_product.third.exportchart', compact(['reseller', 'stock', 'products', 'types']));
                return $pdf->download('Daftar Barang Reseller - ' . $reseller->firstname . ' ' . $reseller->lastname . date('F Y') . '.pdf');
            }
        }
        return back();
    }

    function deleteProduct($id)
    {
        $product = Product::where('id', $id)->first();
        $product->update(array('stok' => 0));

        $allProduct = Product::all();
        foreach ($allProduct as $p) {
            if ($p->id_productType == $product->id_productType) {
                $p->update(array('stok' => 0));
                Product::destroy($p->id);
            }
        }
        Product::destroy($product->id);
        ProductType::destroy($product->id_productType);

        return view('manage_product.main.index', ['products' => Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->select('products.*')->get()]);
    }

    public function category()
    {
        $categories = Category::all();

        return view('manage_product.category.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('manage_product.category.create');
    }

    public function storeCategory(Request $request)
    {
        try {
            $request->validate([
                'nama_kategori' => 'required'
            ]);

            Category::create($request->all());

            return redirect()->route('category.index')->with('create_success', "Kategori $request->nama_kategori berhasil ditambahkan");
        } catch (Exception $e) {
            return back()->with('create_failed', 'Tidak boleh kosong');
        }
    }

    public function editCategory(Category $category)
    {
        return view('manage_product.category.edit', compact('category'));
    }

    public function updateCategory(Category $category, Request $request)
    {
        try {
            $request->validate([
                'nama_kategori' => 'required'
            ]);

            $category->update($request->all());

            return redirect()->route('category.index')->with('update_success', "Kategori berhasil diupdate menjadi $request->nama_kategori");
        } catch (Exception $e) {
            return back()->with('update_failed', 'Tidak boleh kosong');
        }
    }

    public function destroyCategory(Category $category)
    {
        $product = Product::where('id_category', $category->id)->count();
        if ($product == 0) {
            $category->delete();
            return back()->with('delete_success', "Kategori $category->nama_kategori berhasil dihapus");
        }
        return back()->with('delete_error', "Kategori $category->nama_kategori Masih Digunakan");
    }

    public function exportCategory()
    {
        $categories = Category::all();
        $pdf = PDF::loadView('manage_product.category.export', compact('categories'));
        return $pdf->download('Kategori Barang -' . date('F Y') . '.pdf');
    }
}
