<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmClaimRewardHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function owner(){
        return $this->belongsTo(User::class, 'id_owner');
    }
}
