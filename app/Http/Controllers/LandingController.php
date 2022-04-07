<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductHistoric;
use Exception;
use Log;

class LandingController extends Controller
{
    public function test() {
       
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $output = curl_exec($ch);

        dd($output);
        // close curl resource to free up system resources
        curl_close($ch);
    }

    public function setPrice(Request $request) {
        try {
            $product = Product::find($request->id);

            if($product->price != $request->price) {
                ProductHistoric::create(['product_id' => $product->id, 'old_price' => $product->price, 'new_price' => $request->price]);
                $product->update(['price' => $request->price]);
            }
            
            return response()->json('ok');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json('error');
        }
    }
}
