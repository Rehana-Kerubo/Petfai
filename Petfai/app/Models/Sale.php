<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['cashier_id', 'total', 'payment_method'];

public function items()
{
    return $this->hasMany(SaleItem::class);
}

public function cashier()
{
    return $this->belongsTo(User::class, 'cashier_id');
}
}
