<?php

namespace App\Http\Controllers;

// use Mail;
use Auth;
use Exception;
use Throwable;
use App\Models\Web;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Models\ProductHistoric;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\UserEmailNotification;

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
            $web = Web::find($item->pivot->web_id);
            // dd($item->pivot->web_id);
            // dd($test->pivot->price);
            array_push($productPrices, [
                'id' => $productName->id,
                'product' => $productName->name,
                'webId' => $item->pivot->web_id,
                'webName' => $web->name ?? NULL,
                'webUrl' => $web->url ?? NULL,
                'price' => $item->pivot->price
            ]);
        }
        $suscriptions = Auth::user()->suscriptions->where('product_id', $request->productId);
        return [json_encode($suscriptions), json_encode($productPrices) ?? NULL];
    }

    public function suscribe(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->is_premium) {
                UserEmailNotification::updateOrCreate(
                    [
                        'user_id' => Auth::user()->id,
                        'web_id' => $request->webId,
                        'product_id' => $request->productId
                    ],
                    [
                        'user_id' => Auth::user()->id,
                        'web_id' => $request->webId,
                        'product_id' => $request->productId,
                        'active' => 1
                    ]
                );
                $msg = ['Suscribed successfully.', 'success'];
                // } else if (count(UserEmailNotification::where(['user_id', 'active'], '=', [2, 1])->get()) < 1) {
            } else if (count(UserEmailNotification::select("*")->where([['user_id', '=', Auth::user()->id], ['active', '=', 1]])->get()) < 1) {
                UserEmailNotification::updateOrCreate(
                    [
                        'user_id' => Auth::user()->id,
                        'web_id' => $request->webId,
                        'product_id' => $request->productId,
                    ],
                    [
                        'user_id' => Auth::user()->id,
                        'web_id' => $request->webId,
                        'product_id' => $request->productId,
                        'active' => 1
                    ]
                );
                $msg = ['Suscribed successfully.', 'success'];
            } else {
                $msg = ['You cannot subscribe to more than 1 product. To subscribe to more than one product, you need to be premium', 'danger'];
            }
        } else {
            $msg = ['You can\'t suscribe. You have not logged in', 'danger'];
        }

        return $msg;
    }

    public function unsuscribe(Request $request)
    {
        if (Auth::check()) {
            try {
                UserEmailNotification::where(
                    [
                        ['user_id', '=', Auth::user()->id],
                        ['web_id', '=', $request->webId],
                        ['product_id', '=', $request->productId]
                    ]
                )->update(
                    [
                        'active' => 0,
                    ]
                );

                $msg = ['Unsuscribed successfully.', 'success'];
            } catch (\Throwable $th) {
                $msg = ['ERROR', 'danger'];
            }
        }


        return $msg;
    }
}
