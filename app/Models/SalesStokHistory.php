<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesStokHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function retur_histories()
    {
        return $this->hasMany(ReturHistory::class);
    }
}
