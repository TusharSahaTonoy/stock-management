<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockLog extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'action_type', 'date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
