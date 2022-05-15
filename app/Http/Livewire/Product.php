<?php

namespace App\Http\Livewire;

use App\Models\Product as ProductModel;
use Livewire\Component;

class Product extends Component
{
    public $selected = '';
    public $products;

    public function mount()
    {
        $this->products = [];
    }

    public function render()
    {
        $this->products = ProductModel::all();
        return view('livewire.product');
    }
}
