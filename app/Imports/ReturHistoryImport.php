<?php

namespace App\Imports;

use App\Models\ReturHistory;
use App\Models\TransactionHistory;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class ReturHistoryImport implements ToModel, WithHeadingRow
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
            $idSupplier = User::where('id_group',auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            return new ReturHistory([
                'id_transaction'=>TransactionHistory::where('transaction_code', $row['kode_transaksi'])->first()->id,
                'id_group'=>auth()->user()->id_group,
                'id_supplier'=>$idSupplier->id,
                'id_owner'=>auth()->user()->id,
                'id_input'=>auth()->user()->id,
                'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
                'id_approve'=>$idSupplier->id,
                'nama_approve'=>$idSupplier->firstname." ".$idSupplier->lastname,
                'surat_keluar'=>$row['surat_keluar'],
                'keterangan'=>$row['keterangan'],
                'jumlah_barang'=>$row['jumlah_barang'],
                'total'=>$row['total'],
                'status_retur'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),   
            ]);
        }
        else
        {
            $idSupplier = User::where('user_position', 'superadmin_pabrik')->first();
            $idOwner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            return new ReturHistory([
                'id_transaction'=>TransactionHistory::where('transaction_code', $row['kode_transaksi'])->first()->id,
                'id_group'=>auth()->user()->id_group,
                'id_supplier'=>$idSupplier->id,
                'id_owner'=>$idOwner->id,
                'id_input'=>auth()->user()->id,
                'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
                'id_approve'=>$idSupplier->id,
                'nama_approve'=>$idSupplier->firstname." ".$idSupplier->lastname,
                'surat_keluar'=>$row['surat_keluar'],
                'keterangan'=>$row['keterangan'],
                'jumlah_barang'=>$row['jumlah_barang'],
                'total'=>$row['total'],
                'status_retur'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
            
        }
    }
}
