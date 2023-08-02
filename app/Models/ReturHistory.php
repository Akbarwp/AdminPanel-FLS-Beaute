<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transaction(){
        return $this->belongsTo(TransactionHistory::class, 'id_transaction');
    }
    
    public function sales_stok(){
        return $this->belongsTo(SalesStokHistory::class, 'id_transaction');
    }

    public function pasok(){
        return $this->belongsTo(SupplyHistory::class, 'id_transaction');
    }

    public function supplier(){
        return $this->belongsTo(User::class, 'id_supplier');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'id_owner');
    }
}
