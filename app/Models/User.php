<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function group(){
        return $this->belongsTo(Group::class, 'id_group');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public function transaction_history()
    {
        return $this->hasMany(TransactionHistory::class);
    }

    public function tracking_sales_history()
    {
        return $this->hasMany(TrackingSalesHistory::class);
    }

    public function retur_histories()
    {
        return $this->hasMany(ReturHistory::class);
    }

    public function crm_claim_reward_histories()
    {
        return $this->hasMany(CrmClaimRewardHistory::class);
    }
}
