<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function product_histories()
    {
        return $this->hasMany(ProductHistory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function crm_poins()
    {
        return $this->hasOne(CrmPoin::class);
    }

    public function sales_products()
    {
        return $this->hasMany(SalesProduct::class);
    }
}
