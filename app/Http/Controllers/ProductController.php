<?php

namespace App\Http\Controllers;

use App\models\Plati;
use App\View\ProductView;
use Illuminate\Http\Request;
use Meta;

class ProductController extends Controller
{
    public function product($id, Plati $plati)
    {
        $q = '';
        $product = $plati->getProduct($id);

        //transformations
        $product->price = $product->price_goods->wmr;

        //transformations

        $sidebar = $plati->getSidebar();
        $statistics = $plati->getStatistics();
        $productHelper = new ProductView();
        $title = $productHelper->prepareDescription($product->{'name_goods'});
        $keywords = 'купить ключ ' . $title;
        Meta::set('title', "Купить $title");
        Meta::set('description', "Купить $title");
        Meta::set('keywords', $keywords);
        return view('product', compact('product', 'sidebar', 'statistics', 'q'));
    }

    public function buy(Request $request)
    {
        // todo add Sale model
        /*
            sale = Sale.new
            sale.ip= request.env['REMOTE_ADDR']
            sale.user_agent= request.user_agent
            sale.product= id
            sale.is_bot = check_is_bot
            sale.save
          end
         * */
        $id = (int)$request->input('product');
        $referralCode = env('REFERRAL_CODE');
        $domain = env('APP_URL');
        return redirect("https://www.oplata.info/asp2/pay_wm.asp?id_d=$id&id_po=0&ai=$referralCode&" .
            "curr=WMR&failpage=$domain/products/$id&lang=ru-RU&nocash=973411");
    }
}
