<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionHistorySell extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function DBaddHistorySell($data)
    {
        DB::table('transaction_history_sells')->insert($data);
    }

}
