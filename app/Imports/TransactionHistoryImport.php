<?php

namespace App\Imports;

use App\Models\TransactionHistory;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class TransactionHistoryImport implements ToModel, WithHeadingRow
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
            $idDistributor = User::where('id_group',auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            return new TransactionHistory([
                'transaction_code'=>$row['kode_transaksi'],
                    'id_group'=>auth()->user()->id_group,
                    'id_distributor'=>$idDistributor->id,
                    'id_owner'=>auth()->user()->id,
                    'id_input'=>auth()->user()->id,
                    'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
                    'jumlah_barang'=>$row['jumlah_barang'],
                    'tanggal_pesan'=>date("Y-m-d"),
                    'jam_pesan'=>date("h:i:sa"),
                    'total'=>$row['total'],
                    'status_pesanan'=>0,
                    'metode_pembayaran'=>$row['metode_pembayaran'],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
        else
        {
            $idDistributor = User::where('user_position', 'superadmin_pabrik')->first();
            $idOwner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            return new TransactionHistory([
                'transaction_code'=>$row['kode_transaksi'],
                'id_group'=>auth()->user()->id_group,
                'id_distributor'=>$idDistributor->id,
                'id_owner'=>$idOwner->id,
                'id_input'=>auth()->user()->id,
                'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
                'jumlah_barang'=>$row['jumlah_barang'],
                'tanggal_pesan'=>date("Y-m-d"),
                'jam_pesan'=>date("h:i:sa"),
                'total'=>$row['total'],
                'status_pesanan'=>0,
                'metode_pembayaran'=>$row['metode_pembayaran'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
            
        }
    }
}
