<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function DBaddHistories($data)
    {
        DB::table('transaction_histories')->insert($data);
    }

    public function owner(){
        return $this->belongsTo(User::class, 'id_owner');
    }

    public function distributor(){
        return $this->belongsTo(User::class, 'id_distributor');
    }

    public function retur_histories()
    {
        return $this->hasMany(ReturHistory::class);
    }

    public function transaction_detail_sells()
    {
        return $this->hasMany(TransactionDetailSell::class);
    }
}
