<?php

namespace App\Http\Controllers;

use App\models\Plati;
use Illuminate\Http\Request;

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
        return view('product', compact('product', 'q', 'sidebar'));
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
