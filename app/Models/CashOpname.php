<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashOpname extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama_distributor',
        'cash_awal',
        'total_transaksi',
        'cash_akhir',
        'selisih',
        'status',
    ];
}
