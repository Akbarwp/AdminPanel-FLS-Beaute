<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionDetailSell extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function DBaddDetailsSell($data)
    {
        DB::table('transaction_detail_sells')->insert($data);
    }

    public function transaction_history()
    {
        $this->belongsTo(TransactionHistory::class);
    }

    public function transaction_history_sell()
    {
        $this->belongsTo(TransactionHistorySell::class);
    }
}
