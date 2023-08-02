<?php

namespace App\Imports;

use App\Models\ReturDetail;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\TransactionHistory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class ReturDetailImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        date_default_timezone_set('Asia/Jakarta');
        $produk_type = ProductType::where('nama_produk', $row['nama_produk'])->first();
        return new ReturDetail([
            'id_transaction'=>TransactionHistory::where('transaction_code', $row['kode_transaksi'])->first()->id,
            'nama_produk'=>$row['nama_produk'],
            'jumlah'=>$row['jumlah'],
            'harga'=>$row['harga'],
            'total'=>$row['total'],
            'id_product'=>Product::where('id_owner', auth()->user()->id)->where('id_productType', $produk_type->id)->first()->id,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
