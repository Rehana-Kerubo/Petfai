<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name',
    'category',
    'buying_price',
    'selling_price',
    'stock_quantity',
    'low_stock_threshold',
];
public function saleItems()
{
    return $this->hasMany(SaleItem::class);
}
}
