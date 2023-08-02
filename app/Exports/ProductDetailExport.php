<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use App\Models\TransactionDetail;
use App\Models\ReturDetail;
use App\Models\TransactionDetailSell;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductDetailExport implements FromView
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        if(auth()->user()->lihat_barang == 1)
        {
            $product = Product::where('id', $this->id)->first();
            if(auth()->user()->id_group == 1)
            {
                $masuk = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->where('supply_details.id_product', $product->id)->select('supply_histories.*', 'supply_details.jumlah')->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', 1)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*','transaction_details.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', 1)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*','retur_details.jumlah')->get();
                return view('manage_product.main.exportDetailXlsx', compact(['product', 'masuk', 'keluar', 'keluarRetur']));
            }
            else if(auth()->user()->user_position != "reseller")
            {
                $produkPusat = Product::where('id_productType', $product->id_productType)->where('id_group', 1)->first();
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();
                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkPusat->id)->get();
                $keluar = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $distributor->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $product->id)->select('transaction_histories.*','transaction_details.jumlah')->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_distributor', $distributor->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*','transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', $distributor->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*','retur_details.jumlah')->get();
                return view('manage_product.main.exportDetailXlsx', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
            }
            else if(auth()->user()->user_position == "reseller")
            {
                $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', "superadmin_distributor")->first();
                $produkDistributor = Product::where('id_productType', $product->id_productType)->where('id_owner', $distributor->id)->first();
                $masuk = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', auth()->user()->id)->where('transaction_histories.status_pesanan', 1)->where('transaction_details.id_product', $produkDistributor->id)->get();
                $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', auth()->user()->id)->where('tracking_sales_details.id_produk', $product->id)->get();
                $keluarKasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', auth()->user()->id)->where('transaction_history_sells.status_pesanan', 1)->where('transaction_detail_sells.id_product', $product->id)->select('transaction_history_sells.*','transaction_detail_sells.jumlah')->get();
                $keluarRetur = ReturDetail::join('retur_histories', 'retur_histories.id', '=', 'retur_details.id_retur')->where('retur_histories.id_owner', auth()->user()->id)->where('retur_histories.status_retur', 1)->where('retur_details.id_product', $product->id)->select('retur_histories.*','retur_details.jumlah')->get();
                return view('manage_product.main.exportDetailXlsx', compact(['product', 'masuk', 'keluar', 'keluarKasir', 'keluarRetur']));
            }
        }
    }
}