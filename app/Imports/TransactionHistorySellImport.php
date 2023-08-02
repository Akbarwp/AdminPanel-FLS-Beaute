<?php

namespace App\Imports;

use App\Models\TransactionDetailSell;
use App\Models\TransactionHistorySell;
use App\Models\User;
use App\Models\UserHistory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;;

class TransactionHistorySellImport implements ToModel, WithHeadingRow
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
            return new TransactionHistorySell([
                'transaction_code'=>$row['kode_transaksi'],
                'id_group'=>auth()->user()->id_group,
                'id_distributor'=>$idDistributor->id,
                'id_owner'=>auth()->user()->id,
                'id_input'=>auth()->user()->id,
                'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
                'nama_pembeli'=>$row['nama_pembeli'],
                'jumlah_barang'=>$row['jumlah_barang'],
                'tanggal_pesan'=>date("Y-m-d"),
                'jam_pesan'=>date("h:i:sa"),
                'diskon'=>$row['diskon'],
                'keterangan_diskon'=>$row['keterangan_diskon'],
                'total'=>$row['total'],
                'status_pesanan'=>1,
                'metode_pembayaran'=>$row['metode_pembayaran'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Import transaksi '". $data['transaction_code']. "'";
            UserHistory::create($newActivity);
        }
        else
        {
        // DISTRIBUTOR JUAL = DIST DAPET POIN
            $idDistributor = User::where('id_group',auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $idOwner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            return new TransactionHistorySell([
                'transaction_code'=>$row['kode_transaksi'],
                'id_group'=>auth()->user()->id_group,
                'id_distributor'=>$idDistributor->id,
                'id_owner'=>$idOwner->id,
                'id_input'=>auth()->user()->id,
                'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
                'nama_pembeli'=>$row['nama_pembeli'],
                'jumlah_barang'=>$row['jumlah_barang'],
                'tanggal_pesan'=>date("Y-m-d"),
                'jam_pesan'=>date("h:i:sa"),
                'diskon'=>$row['diskon'],
                'keterangan_diskon'=>$row['keterangan_diskon'],
                'total'=>$row['total'],
                'status_pesanan'=>1,
                'metode_pembayaran'=>$row['metode_pembayaran'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Import transaksi '". $data['transaction_code']. "'";
            UserHistory::create($newActivity);
        }
    }
}
