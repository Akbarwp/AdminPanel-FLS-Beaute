<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'province_id'
    ];

    /**
     * City belongs to Province
     * 
     * @return BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * City has many user
     * 
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
