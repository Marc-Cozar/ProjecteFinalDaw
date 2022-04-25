<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'url'];

    public function products_prices(){
        return $this->belongsToMany(Product::class)->withPivot('price');
   }
}
