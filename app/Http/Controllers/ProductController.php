<?php

namespace App\Http\Controllers;

use App\Models\Plati;
use App\Models\Sale;
use App\View\ProductView;
use Illuminate\Http\Request;
use Meta;

class ProductController extends Controller
{
    public function product($id, Plati $plati)
    {
        $product = $plati->getProduct($id);

        /**transformations**/
        $product->{'price'} = $product->{'price_goods'}->wmr;
        /**transformations**/

        $productHelper = new ProductView();
        $title = $productHelper->prepareDescription($product->{'name_goods'});
        $keywords = 'купить ключ ' . $title;
        Meta::set('title', "Купить $title" . ' | SellerStore.ru');
        Meta::set('description', "Купить $title");
        Meta::set('keywords', $keywords);

        $responses = $plati->getResponses($id, (int)$product->{'id_seller'});

        return view('product', compact('product', 'responses'));
    }

    public function buy(Request $request)
    {
        $id = (int)$request->input('product');
        $sale = new Sale();
        $sale->product = $id;
        $sale->ip = $request->ip();
        $userAgent = $request->userAgent();
        $sale->user_agent = $userAgent;
        $sale->is_bot = $this->checkUserAgent($userAgent);
        $sale->save();
        $referralCode = env('REFERRAL_CODE');
        $domain = env('APP_URL');
        return redirect("https://www.oplata.info/asp2/pay_wm.asp?id_d=$id&id_po=0&ai=$referralCode&" .
            "curr=WMR&failpage=$domain/products/$id&lang=ru-RU&nocash=973411");
    }

    private function checkUserAgent(string $userAgent): bool
    {
        return strpos($userAgent, 'Googlebot') !== false
            || strpos($userAgent, 'YandexBot') !== false;
    }
}
