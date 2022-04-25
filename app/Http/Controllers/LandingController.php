<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Web;
use App\Models\ProductHistoric;
use Exception;
use Log;

class LandingController extends Controller
{
    public function test() {
        // dd(Product::find(1)->web_prices()->where('web_id', 1)->first()->pivot);
        foreach(Web::find(1)->products_prices as $test) {
            dd($test->pivot->price);
        }
       
    }

    public function setPrice(Request $request) {
        try {
            $product = Product::find($request->id);

            $old_price = $product->web_prices()->where('web_id', $request->web_id)->first();

            if(!$old_price || $old_price->price != $request->price) {
                $product->web_prices()->detach($request->web_id);
                $new_price = $product->web_prices()->attach($request->web_id, ['price' => $request->price]);
                if($old_price && $old_price->pivot->price != $product->web_prices()->where('web_id', $request->web_id)->first()->pivot->price) {
                    ProductHistoric::updateOrCreate(['product_id' => $product->id, 'old_price' => $old_price->pivot->price, 'new_price' => $request->price, 'web_id' => $request->web_id]);
                }   
            }
            
            return response()->json('ok');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json('error');
        }
    }
}
