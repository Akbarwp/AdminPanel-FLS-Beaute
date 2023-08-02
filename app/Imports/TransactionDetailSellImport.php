<?php

namespace App\Imports;

use App\Models\TransactionDetailSell;
use App\Models\TransactionHistorySell;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use App\Models\CrmPoin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class TransactionDetailSellImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        date_default_timezone_set('Asia/Jakarta');
        if(auth()->user()->user_position == "reseller")
        {
        // RESELLER JUAL = RESELLER DAN DISTRIBUTOR DAPAT POIN
            $idDistributor = User::where('id_group',auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $total_crm_poin_distributor = 0;
            $total_crm_poin_reseller = 0;

            $produk_type = ProductType::where('nama_produk', $row['nama_produk'])->first();
            $produk = Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first();
            $crm_poin = CrmPoin::where('id_productType', $produk->id_productType)->first();
            

            return new TransactionDetailSell([
                'id_transaction'=>TransactionHistorySell::where('transaction_code', $row['kode_transaksi'])->first()->id,
                'nama_produk'=>$row['nama_produk'],
                'jumlah'=>$row['jumlah'],
                'harga'=>$row['harga'],
                'total'=>$row['total'],
                'id_product'=>Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first()->id,
                'crm_poin_distributor'=>$crm_poin->distributor_reseller_jual*$row['jumlah'],
                'crm_poin_reseller'=>$crm_poin->reseller_jual*$row['jumlah'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);

            $product = Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first();
            $jumlahStok = $product->stok - $row['jumlah'];
            $product->stok = $jumlahStok;
            $product->save();

            $total_crm_poin_distributor += $crm_poin->distributor_reseller_jual * $row['jumlah'];
            $total_crm_poin_reseller += $crm_poin->reseller_jual * $row['jumlah'];

            $dist = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $dist->update(array('crm_poin' => $total_crm_poin_distributor + $dist->crm_poin));
            $res = User::where('id', auth()->user()->id)->first();
            $res->update(array('crm_poin' => $total_crm_poin_reseller + $res->crm_poin));

            $transaksi = TransactionHistorySell::latest()->first();
            $transaksi->update(array('total_crm_poin_distributor' => $total_crm_poin_distributor));
            $transaksi->update(array('total_crm_poin_reseller' => $total_crm_poin_reseller));
        }
        else
        {
        // DISTRIBUTOR JUAL = DIST DAPET POIN
            $idDistributor = User::where('id_group',auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $idOwner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $total_crm_poin_distributor = 0;

            $produk_type = ProductType::where('nama_produk', $row['nama_produk'])->first();
            $produk = Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first();
            $crm_poin = CrmPoin::where('id_productType', $produk->id_productType)->first();

            return new TransactionDetailSell([
                'id_transaction'=>TransactionHistorySell::where('transaction_code', $row['kode_transaksi'])->first()->id,
                'nama_produk'=>$row['nama_produk'],
                'jumlah'=>$row['jumlah'],
                'harga'=>$row['harga'],
                'total'=>$row['total'],
                'id_product'=>Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first()->id,
                'crm_poin_distributor'=>$crm_poin->distributor_jual*$row['jumlah'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);

            $product = Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first();
            $jumlahStok = $product->stok - $row['jumlah'];
            $product->stok = $jumlahStok;
            $product->save();

            $total_crm_poin_distributor += $crm_poin->distributor_jual * $row['jumlah'];

            $dist = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $dist->update(array('crm_poin' => $total_crm_poin_distributor + $dist->crm_poin));
            $transaksi = TransactionHistorySell::latest()->first();
            $transaksi->update(array('total_crm_poin_distributor' => $total_crm_poin_distributor));
    }}
}
