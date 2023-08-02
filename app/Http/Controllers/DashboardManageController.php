<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\ReturDetail;
use App\Models\ReturHistory;
use App\Models\SalesStokDetail;
use App\Models\SalesStokHistory;
use App\Models\SupplyDetail;
use App\Models\SupplyHistory;
use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use App\Models\TrackingSalesDetail;
use App\Models\TrackingSalesHistory;
use PDF;
use App\Models\TransactionDetailSell;
use App\Models\TransactionHistorySell;

class DashboardManageController extends Controller
{
    public function viewDashboard()
    {
        $MAXSHOW = 3;
        if (auth()->user()->id_group == 1) {
            // pusat
            // $pusat = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();

            // $stokPenjualan = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $pusat->id)->where('status_pesanan', 1)->sum('jumlah');
            // $totalPenjualan = TransactionHistory::where('id_distributor', $pusat->id)->where('status_pesanan', 1)->sum('total');

            // $stokPembelian = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->sum('jumlah');
            // $totalPembelian = SupplyHistory::sum('total');

            // $products = Product::where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            // $stok = $products->sum('stok');

            $pusat = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();

            $stokPenjualan1 = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $pusat->id)->where('status_pesanan', 1)->sum('jumlah');
            $stokPenjualan2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $pusat->id)->sum('jumlah');
            $stokPenjualan = $stokPenjualan1 + $stokPenjualan2;

            $totalPenjualan1 = TransactionHistory::where('id_distributor', $pusat->id)->where('status_pesanan', 1)->sum('total');
            $totalPenjualan2 = TransactionHistorySell::where('id_owner', $pusat->id)->sum('total');
            $totalPenjualan = $totalPenjualan1 + $totalPenjualan2;

            $totalTransPenjualan1 = TransactionHistory::where('id_distributor', $pusat->id)->where('status_pesanan', 1)->count();
            $totalTransPenjualan2 = TransactionHistorySell::where('id_owner', $pusat->id)->count();
            $totalTransPenjualan = $totalTransPenjualan1 + $totalTransPenjualan2;

            $stokPembelian = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $pusat->id)->where('status_pesanan', 1)->sum('jumlah');
            $totalPembelian = TransactionHistory::where('id_owner', $pusat->id)->where('status_pesanan', 1)->sum('total');

            $stokRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $pusat->id)->where('status_retur', 1)->sum('jumlah');
            $totalRetur = ReturHistory::where('id_owner', $pusat->id)->where('status_retur', 1)->sum('total');
            $totalTransRetur = ReturHistory::where('id_owner', $pusat->id)->where('status_retur', 1)->count();

            $products = Product::where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            $stok = $products->sum('stok');

            // RIWAYAT PENJUALAN
            $ownerPjl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $transactionsPjl = TransactionHistory::where('id_distributor', $ownerPjl->id)->where('status_pesanan', 1)->get();
            $detailsPjl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $ownerPjl->id)->select('transaction_details.*')->get();
            $transactionsPjl2 = TransactionHistorySell::where('id_owner', $ownerPjl->id)->get();
            $detailsPjl2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $ownerPjl->id)->select('transaction_detail_sells.*')->get();

            // RIWAYAT PEMBELIAN
            // $ownerPbl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            // $transactionsPbl = TransactionHistory::where('id_owner', $ownerPbl->id)->where('status_pesanan',1)->get();
            // $detailsPbl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $ownerPbl->id)->select('transaction_details.*')->get();
            $ownerPbl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $transactionsPbl = SupplyHistory::whereMonth('supply_histories.updated_at', Carbon::now()->month)->get();
            $detailsPbl = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->select('supply_details.*')->get();
            // distributors
            // $distributors = User::where('user_position', 'superadmin_distributor')->get();

            // $distributorStoks = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->take($MAXSHOW)->get();

            // $distributors->map(function ($dist) {
            //     $totalPenjualan1 = TransactionHistory::where('id_distributor', $dist['id'])->sum('total');
            //     $totalPenjualan2 = TransactionHistorySell::where('id_owner', $dist['id'])->sum('total');

            //     $dist['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
            //     return $dist;
            // });
            // $distributorPenjualans = $distributors->sortByDesc(function($d)
            // {
            //     return $d->totalPenjualan;
            // });
            // $distributorPenjualans = $distributorPenjualans->take($MAXSHOW);

            // $distributorReturs = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'superadmin_distributor')->where('status_retur', 1)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->take($MAXSHOW)->get();

            // resellers + sales
            // $resellers = User::where('user_position', 'reseller')->orWhere('user_position', 'sales')->orderBy('id_group', 'asc')->get();
            // $resellerStoks = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->take($MAXSHOW)->get();

            // $resellers->map(function ($res) {
            //     $totalPenjualan1 = TrackingSalesHistory::where('id_reseller', $res['id'])->sum('total');
            //     $totalPenjualan2 = TransactionHistorySell::where('id_owner', $res['id'])->sum('total');

            //     $res['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
            //     return $res;
            // });
            // $resellerPenjualans = $resellers->sortByDesc(function($d)
            // {
            //     return $d->totalPenjualan;
            // });
            // $resellerPenjualans = $resellerPenjualans->take($MAXSHOW);

            // $resellerReturs = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->where('status_retur', 1)->orWhere('user_position', 'sales')->where('status_retur', 1)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->take($MAXSHOW)->get();

            // return view('dashboard.index1', compact(['stokPenjualan', 'totalPenjualan', 'stokPembelian', 'totalPembelian', 'products', 'stok', 'distributorStoks', 'distributorPenjualans', 'distributorReturs', 'resellerStoks', 'resellerPenjualans', 'resellerReturs']));

            return view('dashboard.index', compact(['pusat', 'stokPenjualan', 'totalPenjualan', 'totalTransPenjualan', 'stokPembelian', 'totalPembelian', 'stokRetur', 'totalRetur', 'totalTransRetur', 'products', 'stok', 'ownerPjl', 'transactionsPjl', 'transactionsPjl2', 'detailsPjl', 'detailsPjl2', 'ownerPbl', 'transactionsPbl', 'detailsPbl']));
        } else if (auth()->user()->id_group != 1 && auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            // distributor
            $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            $stokPenjualan1 = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $distributor->id)->where('status_pesanan', 1)->sum('jumlah');
            $stokPenjualan2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $distributor->id)->sum('jumlah');
            $stokPenjualan = $stokPenjualan1 + $stokPenjualan2;

            $totalPenjualan1 = TransactionHistory::where('id_distributor', $distributor->id)->where('status_pesanan', 1)->sum('total');
            $totalPenjualan2 = TransactionHistorySell::where('id_owner', $distributor->id)->sum('total');
            $totalPenjualan = $totalPenjualan1 + $totalPenjualan2;

            $totalTransPenjualan1 = TransactionHistory::where('id_distributor', $distributor->id)->where('status_pesanan', 1)->count();
            $totalTransPenjualan2 = TransactionHistorySell::where('id_owner', $distributor->id)->count();
            $totalTransPenjualan = $totalTransPenjualan1 + $totalTransPenjualan2;

            $stokPembelian = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $distributor->id)->where('status_pesanan', 1)->sum('jumlah');
            $totalPembelian = TransactionHistory::where('id_owner', $distributor->id)->where('status_pesanan', 1)->sum('total');

            $stokRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $distributor->id)->where('status_retur', 1)->sum('jumlah');
            $totalRetur = ReturHistory::where('id_owner', $distributor->id)->where('status_retur', 1)->sum('total');
            $totalTransRetur = ReturHistory::where('id_owner', $distributor->id)->where('status_retur', 1)->count();

            $products = Product::where('id_owner', $distributor->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            $stok = $products->sum('stok');

            // resellers + sales
            $resellerStoks = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->where('users.id_group', $distributor->id_group)->orWhere('user_position', 'sales')->where('users.id_group', $distributor->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->take($MAXSHOW)->get();

            $resellers = User::where('user_position', 'reseller')->orWhere('user_position', 'sales')->where('users.id_group', $distributor->id_group)->where('users.id_group', $distributor->id_group)->get();
            $resellers->map(function ($res) {
                $totalPenjualan1 = TrackingSalesHistory::where('id_reseller', $res['id'])->sum('total');
                $totalPenjualan2 = TransactionHistorySell::where('id_owner', $res['id'])->sum('total');

                $res['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                return $res;
            });
            $resellerPenjualans = $resellers->sortByDesc(function ($d) {
                return $d->totalPenjualan;
            });
            $resellerPenjualans = $resellerPenjualans->take($MAXSHOW);

            // $resellerReturs = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->where('users.id_group', $distributor->id_group)->orWhere('user_position', 'sales')->where('users.id_group', $distributor->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->take($MAXSHOW)->get();
            $resellerReturs = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('users.user_position', 'reseller')->where('users.id_group', $distributor->id_group)->where('retur_histories.status_retur', 1)->orWhere('users.user_position', 'sales')->where('users.id_group', $distributor->id_group)->where('retur_histories.status_retur', 1)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->take($MAXSHOW)->get();
            // $resellerReturs = User::crossJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('users.user_position', 'reseller')->where('users.id_group', $distributor->id_group)->orWhere('users.user_position', 'sales')->where('users.id_group', $distributor->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->take($MAXSHOW)->get();

            // RIWAYAT PENJUALAN
            $ownerPjl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $transactionsPjl = TransactionHistory::where('id_distributor', $ownerPjl->id)->where('status_pesanan', 1)->get();
            $detailsPjl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $ownerPjl->id)->select('transaction_details.*')->get();
            $transactionsPjl2 = TransactionHistorySell::where('id_owner', $ownerPjl->id)->get();
            $detailsPjl2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $ownerPjl->id)->select('transaction_detail_sells.*')->get();

            // RIWAYAT PEMBELIAN
            $ownerPbl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $transactionsPbl = TransactionHistory::where('id_owner', $ownerPbl->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            $detailsPbl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $ownerPbl->id)->select('transaction_details.*')->get();

            // dd($resellerReturs);
            return view('dashboard.index', compact(['distributor', 'stokPenjualan', 'totalPenjualan', 'totalTransPenjualan', 'stokPembelian', 'totalPembelian', 'stokRetur', 'totalRetur', 'totalTransRetur', 'products', 'stok', 'resellerStoks', 'resellerPenjualans', 'resellerReturs', 'resellers', 'ownerPjl', 'transactionsPjl', 'transactionsPjl2', 'detailsPjl', 'detailsPjl2', 'ownerPbl', 'transactionsPbl', 'detailsPbl']));
        } else if (auth()->user()->user_position == "reseller") {
            $reseller = auth()->user();

            $stokPenjualan1 = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $reseller->id)->where('status_pesanan', 1)->sum('jumlah');
            $stokPenjualan2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $reseller->id)->sum('jumlah');
            $stokPenjualan = $stokPenjualan1 + $stokPenjualan2;

            $totalPenjualan1 = TransactionHistory::where('id_distributor', $reseller->id)->where('status_pesanan', 1)->sum('total');
            $totalPenjualan2 = TransactionHistorySell::where('id_owner', $reseller->id)->sum('total');
            $totalPenjualan = $totalPenjualan1 + $totalPenjualan2;

            $totalTransPenjualan1 = TransactionHistory::where('id_distributor', $reseller->id)->where('status_pesanan', 1)->count();
            $totalTransPenjualan2 = TransactionHistorySell::where('id_owner', $reseller->id)->count();
            $totalTransPenjualan = $totalTransPenjualan1 + $totalTransPenjualan2;

            $stokPembelian = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $reseller->id)->where('status_pesanan', 1)->sum('jumlah');
            $totalPembelian = TransactionHistory::where('id_owner', $reseller->id)->where('status_pesanan', 1)->sum('total');

            $stokRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $reseller->id)->where('status_retur', 1)->sum('jumlah');
            $totalRetur = ReturHistory::where('id_owner', $reseller->id)->where('status_retur', 1)->sum('total');
            $totalTransRetur = ReturHistory::where('id_owner', $reseller->id)->where('status_retur', 1)->count();

            $products = Product::where('id_owner', $reseller->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            $stok = $products->sum('stok');

            // RIWAYAT PENJUALAN
            $ownerPjl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->first();
            $transactionsPjl = TransactionHistory::where('id_distributor', $ownerPjl->id)->where('status_pesanan', 1)->get();
            $detailsPjl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $ownerPjl->id)->select('transaction_details.*')->get();
            $transactionsPjl2 = TransactionHistorySell::where('id_owner', $ownerPjl->id)->get();
            $detailsPjl2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $ownerPjl->id)->select('transaction_detail_sells.*')->get();

            // RIWAYAT PEMBELIAN
            $ownerPbl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->first();
            $transactionsPbl = TransactionHistory::where('id_owner', $ownerPbl->id)->where('status_pesanan', 1)->get();
            $detailsPbl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $ownerPbl->id)->select('transaction_details.*')->get();

            // Lama
            // $stokPenjualan = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $reseller->id)->sum('jumlah');
            // $totalPenjualan = TransactionHistorySell::where('id_owner', $reseller->id)->sum('total');

            // $stokPembelian = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $reseller->id)->where('status_pesanan', 1)->sum('jumlah');
            // $totalPembelian = TransactionHistory::where('id_owner', $reseller->id)->where('status_pesanan', 1)->sum('total');

            // $stokRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $reseller->id)->where('status_retur', 1)->sum('jumlah');
            // $totalRetur = ReturHistory::where('id_owner', $reseller->id)->where('status_retur', 1)->sum('total');

            // $products = Product::where('id_owner', $reseller->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            // $stok = $products->sum('stok');

            // return view('dashboard.index', compact(['reseller', 'stokPenjualan', 'totalPenjualan', 'stokPembelian', 'totalPembelian', 'stokRetur', 'totalRetur', 'products', 'stok']));

            return view('dashboard.index', compact(['reseller', 'stokPenjualan', 'totalPenjualan', 'totalTransPenjualan', 'stokPembelian', 'totalPembelian', 'stokRetur', 'totalRetur', 'totalTransRetur', 'products', 'stok', 'ownerPjl', 'transactionsPjl', 'transactionsPjl2', 'detailsPjl', 'detailsPjl2', 'ownerPbl', 'transactionsPbl', 'detailsPbl']));
        } else if (auth()->user()->user_position == "sales") {
            $sales = auth()->user();

            $stokPenjualan1 = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $sales->id)->where('status_pesanan', 1)->sum('jumlah');
            $stokPenjualan2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $sales->id)->sum('jumlah');
            $stokPenjualan = $stokPenjualan1 + $stokPenjualan2;

            $totalPenjualan1 = TransactionHistory::where('id_distributor', $sales->id)->where('status_pesanan', 1)->sum('total');
            $totalPenjualan2 = TransactionHistorySell::where('id_owner', $sales->id)->sum('total');
            $totalPenjualan = $totalPenjualan1 + $totalPenjualan2;

            $totalTransPenjualan1 = TransactionHistory::where('id_distributor', $sales->id)->where('status_pesanan', 1)->count();
            $totalTransPenjualan2 = TransactionHistorySell::where('id_owner', $sales->id)->count();
            $totalTransPenjualan = $totalTransPenjualan1 + $totalTransPenjualan2;

            $stokPembelian = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $sales->id)->where('status_pesanan', 1)->sum('jumlah');
            $totalPembelian = TransactionHistory::where('id_owner', $sales->id)->where('status_pesanan', 1)->sum('total');

            $stokRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $sales->id)->where('status_retur', 1)->sum('jumlah');
            $totalRetur = ReturHistory::where('id_owner', $sales->id)->where('status_retur', 1)->sum('total');
            $totalTransRetur = ReturHistory::where('id_owner', $sales->id)->where('status_retur', 1)->count();

            $products = Product::where('id_owner', $sales->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            $stok = $products->sum('stok');

            // RIWAYAT PENJUALAN
            $ownerPjl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'sales')->first();
            $transactionsPjl = TransactionHistory::where('id_distributor', $ownerPjl->id)->where('status_pesanan', 1)->get();
            $detailsPjl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $ownerPjl->id)->select('transaction_details.*')->get();
            $transactionsPjl2 = TransactionHistorySell::where('id_owner', $ownerPjl->id)->get();
            $detailsPjl2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $ownerPjl->id)->select('transaction_detail_sells.*')->get();

            // RIWAYAT PEMBELIAN
            $ownerPbl = User::where('id_group', auth()->user()->id_group)->where('user_position', 'sales')->first();
            $transactionsPbl = TransactionHistory::where('id_owner', $ownerPbl->id)->where('status_pesanan', 1)->get();
            $detailsPbl = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $ownerPbl->id)->select('transaction_details.*')->get();

            // Lama
            // $stokPenjualan = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $sales->id)->sum('jumlah');
            // $totalPenjualan = TrackingSalesHistory::where('id_reseller', $sales->id)->sum('total');

            // $stokPengambilan = SalesStokDetail::join('sales_stok_histories', 'sales_stok_histories.id', '=', 'sales_stok_details.id_sales_stok')->where('sales_stok_histories.id_owner', $sales->id)->where('status', 1)->sum('jumlah');
            // $totalPengambilan = SalesStokHistory::where('id_owner', $sales->id)->where('status', 1)->sum('total');

            // $stokRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $sales->id)->where('status_retur', 1)->sum('jumlah');
            // $totalRetur = ReturHistory::where('id_owner', $sales->id)->where('status_retur', 1)->sum('total');

            // $products = Product::where('id_owner', $sales->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*', 'product_types.*')->get();
            // $stok = $products->sum('stok');

            // return view('dashboard.index', compact(['sales', 'stokPenjualan', 'totalPenjualan', 'stokPengambilan', 'totalPengambilan', 'stokRetur', 'totalRetur', 'products', 'stok']));\

            return view('dashboard.index', compact(['sales', 'stokPenjualan', 'totalPenjualan', 'totalTransPenjualan', 'stokPembelian', 'totalPembelian', 'stokRetur', 'totalRetur', 'totalTransRetur', 'products', 'stok', 'ownerPjl', 'transactionsPjl', 'transactionsPjl2', 'detailsPjl', 'detailsPjl2', 'ownerPbl', 'transactionsPbl', 'detailsPbl']));
        }
    }

    public function getDateTransactionSell(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        $output = '
        <table id="logTablePjl" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total</th>';
        if (auth()->user()->id_group != 1 && auth()->user()->user_position != "sales") {
            $output .= '<th scope="col">Diskon</th>';
        }
        $output .= '<th scope="col">Tanggal</th>';
        if (auth()->user()->user_position != "sales") {
            $output .= '<th scope="col">Metode Pembayaran</th>';
        }
        $output .= '<th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->select('*')->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereBetween('transaction_history_sells.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "sales") {
            $owner = auth()->user();
            $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
            if ($request->min != "" && $request->max != "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereBetween('tracking_sales_histories.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereDate('tracking_sales_histories.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereDate('tracking_sales_histories.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereBetween('transaction_history_sells.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '>=', $from)->get();
            }
        }

        foreach ($transactions as $transaction) {

            if (auth()->user()->user_position == "sales") {
                $customerName = $transaction->nama_toko;
                $code = $transaction->id;
                $type = "tracking";
            } else if (auth()->user()->user_position == "reseller") {
                $customerName = "Transaksi Kasir";
                $code = $transaction->transaction_code;
                $type = "kasir";
            } else {
                $customer = User::where('id', $transaction->id_owner)->first();
                $customerName = $customer->firstname . ' ' . $customer->lastname;
                $code = $transaction->transaction_code;
                $type = "beli";
            }
            $direct = url('/manage_report/transaction/sell/print_detail/' . $transaction->id . '/' . $type);


            $output .= '
            <tr id="' . $transaction->id . '">
                <td>' . $code . '</td>
                <td>' . $customerName . '</td>
                <td>Rp. ' . number_format($transaction->total, 0, ',', '.') . '</td>';
            if ($owner->user_position == "reseller" || $owner->user_position == "superadmin_distributor") {
                $output .= '<td>Rp. ' . number_format($transaction->diskon, 0, ',', '.') . '</td>';
            }
            // else if($owner->user_position == "superadmin_distributor")
            // {
            //     $output.='<td>-</td>';
            // }
            $output .= '<td>' . $transaction->updated_at->format('d/m/y H:i:s') . '</td>';
            if ($owner->user_position != "sales") {
                $output .= '<td>' . $transaction->metode_pembayaran . '</td>';
            }
            $output .= '
                <td class="col-2">
                    <div class="col text-left">
                    
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit" ></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link carousel" onclick="functionDetail(' . $transaction->id . ')">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>';
        }

        if ($owner->user_position == "superadmin_distributor") {
            foreach ($transactions2 as $transaction) {
                $type = "kasir";
                $direct = url('/manage_report/transaction/sell/print_detail/' . $transaction->id . '/' . $type);

                $customerName = 'Transaksi Kasir';
                $code = $transaction->transaction_code;

                $output .= '
                <tr id="khusus' . $transaction->id . '">
                    <td>' . $code . '</td>
                    <td>' . $customerName . '</td>
                    <td>Rp. ' . number_format($transaction->total, 0, ',', '.') . '</td>
                    <td>Rp. ' . number_format($transaction->diskon, 0, ',', '.') . '</td>
                    <td>' . $transaction->updated_at->format('d/m/y H:i:s') . '</td>
                    <td>' . $transaction->metode_pembayaran . '</td>
                    <td>
                        <div class="col text-left">
                            <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                                <span><i class="fa fa-edit" ></i>Print</span>
                            </button>
                            <button type="button" class="btn btn-link carousel" onclick="functionDetail2(' . $transaction->id . ')">
                                <span><i class="fa fa-angle-down"></i></span>
                            </button>
                        </div>
                    </td>
                </tr>';
            }
        }
        $output .= '</tbody>
        </table>
        <br>
        <h4>Total : Rp. <span id="totalAllPjl"></span></h4>';
        return response()->json($output);
    }

    public function getDateTransactionBuy(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        $output = '
        <table id="logTablePbl" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = SupplyHistory::whereBetween('supply_histories.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = SupplyHistory::whereMonth('supply_histories.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = SupplyHistory::whereDate('supply_histories.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = SupplyHistory::whereDate('supply_histories.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        }

        foreach ($transactions as $transaction) {
            if ($owner->user_position == "superadmin_pabrik") {
                $code = $transaction->kode_pasok;
            } else {
                $code = $transaction->transaction_code;
            }

            if (auth()->user()->id_group == 1) {
                $direct = url('/manage_report/transaction/buy/print_detail/' . $transaction->id . '/pasok');
            } else {
                $direct = url('/manage_report/transaction/buy/print_detail/' . $transaction->id . '/beli');
            }


            $output .= '
            <tr id="' . $transaction->id . '">
                <td>' . $code . '</td>
                <td>Rp. ' . number_format($transaction->total, 0, ',', '.') . '</td>';
            $output .= '<td>' . $transaction->updated_at->format('d/m/y H:i:s') . '</td>
                <td>' . $transaction->metode_pembayaran . '</td>';

            $output .= '
                <td class="col-2">
                    <div class="col text-left">
                    
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit" ></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link carousel" onclick="functionDetail(' . $transaction->id . ')">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>';
        }
        $output .= '</tbody>
        </table>
        <br>
        <h4>Total : Rp. <span id="totalAllPbl"></span></h4>';
        return response()->json($output);
    }

    public function print()
    {
        if (auth()->user()->id_group == 1) {
            $owner = User::where('id', 1)->first();
        } else if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
        } else if (auth()->user()->user_position == "reseller" || auth()->user()->user_position == "sales") {
            $owner = auth()->user();
        }

        $products = Product::where('id_owner', $owner->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
        $types = ProductType::all();
        $stock = Product::where('id_owner', $owner->id)->sum('stok');

        return view('dashboard.print', compact(['owner', 'products', 'types', 'stock']));
    }

    public function export()
    {
        if (auth()->user()->id_group == 1) {
            $owner = User::where('id', 1)->first();
        } else if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
        } else if (auth()->user()->user_position == "reseller" || auth()->user()->user_position == "sales") {
            $owner = auth()->user();
        }

        $products = Product::where('id_owner', $owner->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
        $types = ProductType::all();
        $stock = Product::where('id_owner', $owner->id)->sum('stok');

        $pdf = PDF::loadView('dashboard.export', compact(['owner', 'products', 'types', 'stock']));

        if (auth()->user()->id_group == 1) {
            return $pdf->download('Stock Barang Pusat - ' . date('F Y') . '.pdf');
        } else {
            return $pdf->download('Stock Barang ' . $owner->firstname . ' ' . $owner->lastname . ' - ' . date('F Y') . '.pdf');
        }
    }

    public function viewDetailTable($user, $type)
    {
        if ($user == "distributor") {
            if ($type == "stok") {
                $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
            } else if ($type == "penjualan") {
                $distributors = User::where('user_position', 'superadmin_distributor')->get();
                $distributors->map(function ($dist) {
                    $totalPenjualan1 = TransactionHistory::where('id_distributor', $dist['id'])->sum('total');
                    $totalPenjualan2 = TransactionHistorySell::where('id_owner', $dist['id'])->sum('total');

                    $dist['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                    return $dist;
                });
                $datas = $distributors->sortByDesc(function ($d) {
                    return $d->totalPenjualan;
                });
            } else if ($type == "retur") {
                $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
            }

            return view('dashboard.detail_table', compact(['user', 'type', 'datas']));
        } else {
            if ($type == "stok") {
                $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                if (auth()->user()->id_group == 1) {
                    $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                } else {
                    $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                }
            } else if ($type == "penjualan") {
                if (auth()->user()->id_group == 1) {
                    $resellers = User::where('user_position', 'reseller')->orWhere('user_position', 'sales')->orderBy('id_group', 'asc')->get();
                } else {
                    $resellers = User::where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->orderBy('id_group', 'asc')->get();
                }

                $resellers->map(function ($res) {
                    $totalPenjualan1 = TrackingSalesHistory::where('id_reseller', $res['id'])->sum('total');
                    $totalPenjualan2 = TransactionHistorySell::where('id_owner', $res['id'])->sum('total');

                    $res['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                    return $res;
                });
                $datas = $resellers->sortByDesc(function ($d) {
                    return $d->totalPenjualan;
                });
            } else if ($type == "retur") {
                if (auth()->user()->id_group == 1) {
                    $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
                } else {
                    $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
                }
            }

            return view('dashboard.detail_table', compact(['user', 'type', 'datas']));
        }

        return back();
    }

    public function print_detail_table($user, $type)
    {
        if ($user == "distributor") {
            if ($type == "stok") {
                $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
            } else if ($type == "penjualan") {
                $distributors = User::where('user_position', 'superadmin_distributor')->get();
                $distributors->map(function ($dist) {
                    $totalPenjualan1 = TransactionHistory::where('id_distributor', $dist['id'])->sum('total');
                    $totalPenjualan2 = TransactionHistorySell::where('id_owner', $dist['id'])->sum('total');

                    $dist['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                    return $dist;
                });
                $datas = $distributors->sortByDesc(function ($d) {
                    return $d->totalPenjualan;
                });
            } else if ($type == "retur") {
                $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
            }

            return view('dashboard.print_detail_table', compact(['user', 'type', 'datas']));
        } else {
            if ($type == "stok") {
                $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                if (auth()->user()->id_group == 1) {
                    $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                } else {
                    $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                }
            } else if ($type == "penjualan") {
                if (auth()->user()->id_group == 1) {
                    $resellers = User::where('user_position', 'reseller')->orWhere('user_position', 'sales')->orderBy('id_group', 'asc')->get();
                } else {
                    $resellers = User::where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->orderBy('id_group', 'asc')->get();
                }

                $resellers->map(function ($res) {
                    $totalPenjualan1 = TrackingSalesHistory::where('id_reseller', $res['id'])->sum('total');
                    $totalPenjualan2 = TransactionHistorySell::where('id_owner', $res['id'])->sum('total');

                    $res['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                    return $res;
                });
                $datas = $resellers->sortByDesc(function ($d) {
                    return $d->totalPenjualan;
                });
            } else if ($type == "retur") {
                if (auth()->user()->id_group == 1) {
                    $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
                } else {
                    $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
                }
            }

            return view('dashboard.print_detail_table', compact(['user', 'type', 'datas']));
        }
    }

    public function export_detail_table($user, $type)
    {
        if ($user == "distributor") {
            if ($type == "stok") {
                $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
            } else if ($type == "penjualan") {
                $distributors = User::where('user_position', 'superadmin_distributor')->get();
                $distributors->map(function ($dist) {
                    $totalPenjualan1 = TransactionHistory::where('id_distributor', $dist['id'])->sum('total');
                    $totalPenjualan2 = TransactionHistorySell::where('id_owner', $dist['id'])->sum('total');

                    $dist['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                    return $dist;
                });
                $datas = $distributors->sortByDesc(function ($d) {
                    return $d->totalPenjualan;
                });
            } else if ($type == "retur") {
                $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'superadmin_distributor')->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
            }

            $pdf = PDF::loadView('dashboard.export_detail_table', compact(['user', 'type', 'datas']));
            return $pdf->download($user . ' ' . $type . ' - ' . date('F Y') . '.pdf');
        } else {
            if ($type == "stok") {
                $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                if (auth()->user()->id_group == 1) {
                    $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                } else {
                    $datas = Product::join('users', 'users.id', '=', 'products.id_owner')->where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(stok) as stok')->orderBy('stok', 'desc')->get();
                }
            } else if ($type == "penjualan") {
                if (auth()->user()->id_group == 1) {
                    $resellers = User::where('user_position', 'reseller')->orWhere('user_position', 'sales')->orderBy('id_group', 'asc')->get();
                } else {
                    $resellers = User::where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->orderBy('id_group', 'asc')->get();
                }

                $resellers->map(function ($res) {
                    $totalPenjualan1 = TrackingSalesHistory::where('id_reseller', $res['id'])->sum('total');
                    $totalPenjualan2 = TransactionHistorySell::where('id_owner', $res['id'])->sum('total');

                    $res['totalPenjualan'] = $totalPenjualan1 + $totalPenjualan2;
                    return $res;
                });
                $datas = $resellers->sortByDesc(function ($d) {
                    return $d->totalPenjualan;
                });
            } else if ($type == "retur") {
                if (auth()->user()->id_group == 1) {
                    $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->orWhere('user_position', 'sales')->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
                } else {
                    $datas = User::leftJoin('retur_histories', 'retur_histories.id_owner', '=', 'users.id')->where('user_position', 'reseller')->where('users.id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('users.id_group', auth()->user()->id_group)->groupBy('users.id')->select('users.*')->selectRaw('sum(total) as totalRetur')->orderBy('totalRetur', 'desc')->get();
                }
            }

            $pdf = PDF::loadView('dashboard.export_detail_table', compact(['user', 'type', 'datas']));
            return $pdf->download($user . ' ' . $type . ' - ' . date('F Y') . '.pdf');
        }
    }
}
