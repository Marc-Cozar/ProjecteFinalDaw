<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $suscriptions = Auth::user()->suscriptions->where('active', 1)->sortBy('product_id');
        return view('front.profile.index')->with('suscriptions', $suscriptions);
    }
}
