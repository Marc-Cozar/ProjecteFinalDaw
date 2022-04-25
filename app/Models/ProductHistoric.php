<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistoric extends Model
{
    use HasFactory;

    protected $table = 'product_price_historic';
    protected $fillable = ['product_id', 'new_price', 'old_price', 'web_id'];
}
