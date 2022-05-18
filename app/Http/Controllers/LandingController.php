<?php

namespace App\Http\Controllers;

// use Mail;
use Exception;
use App\Models\Web;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Models\ProductHistoric;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LandingController extends Controller
{
    public function test()
    {
        dd('entra FUNCTION');
        // dd(Product::find(1)->web_prices()->where('web_id', 1)->first()->pivot);
        foreach (Web::find(1)->products_prices as $test) {
            dd($test->pivot->price);
        }
    }

    public function setPrice(Request $request)
    {
        try {
            $product = Product::find($request->id);

            $old_price = $product->web_prices()->where('web_id', $request->web_id)->first();

            if (!$old_price || $old_price->price != $request->price) {
                $product->web_prices()->detach($request->web_id);
                $new_price = $product->web_prices()->attach($request->web_id, ['price' => $request->price]);
                // if ($old_price && $old_price->pivot->price != $product->web_prices()->where('web_id', $request->web_id)->first()->pivot->price) {
                foreach (DB::table('user_email_notification')->where('web_id', $request->web_id)->where('product_id', $product->id)->get() as $notification) {
                    $user = User::find($notification->user_id);

                    if ($user) {
                        $web = Web::find($request->web_id);
                        $mail = Mail::to($user->email)->send(new NotificationMail(['old_price' => $old_price->pivot->price, 'new_price' => $request->price, 'web' => $web, 'user' => $user, 'product' => $product]));
                        dd($mail);
                    }
                }

                ProductHistoric::updateOrCreate(['product_id' => $product->id, 'old_price' => $old_price->pivot->price, 'new_price' => $request->price, 'web_id' => $request->web_id]);
                // }
            }

            return response()->json('ok');
        } catch (Exception $e) {
            Log::channel('error_info')->info($e->getMessage());
            return response()->json('error');
        }
    }

    public function displayPricesProduct(Request $request)
    {
        $productPrices = [];
        // dd(count(Product::find($request->productId)->web_prices));
        // dd(Product::find(1)->web_prices()->where('web_id', 1)->first()->pivot);
        $productName = Product::find($request->productId);
        foreach (Product::find($request->productId)->web_prices as $item) {
            $webName = Web::find($item->pivot->web_id)->name;
            // dd($webName);
            // dd($test->pivot->price);
            array_push($productPrices, [
                'product' => $productName->name,
                'webName' => $webName ?? NULL,
                'price' => $item->pivot->price
            ]);
        }
        return json_encode($productPrices) ?? NULL;
    }
}
