<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'buy_price', 'sell_price', 'details', 'image'];

    public function stockLog()
    {
        return $this->hasMany(ProductStockLog::class);
    }
}
