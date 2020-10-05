<?php

namespace App\Http\Controllers;

use App\Models\Plati;
use App\Models\Sale;
use App\Models\SaleDto;
use App\Models\UserAgent;
use App\View\ProductView;
use Illuminate\Http\Request;
use Meta;

class ProductController extends Controller
{
    /**
     * @var UserAgent
     */
    private UserAgent $userAgent;

    public function __construct(UserAgent $userAgent)
    {
        $this->userAgent = $userAgent;
    }

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

        $responses = $plati->getResponses((int)$product->{'id_seller'}, $id);

        return view('product.product', compact('product', 'responses'));
    }

    public function buy(Request $request)
    {
        $id = (int)$request->input('product');
        $userAgent = $request->userAgent();
        $sale = new Sale();
        $saleDto = new SaleDto();
        $saleDto->product = $id;
        $saleDto->ip = $request->ip();
        $saleDto->userAgent = $userAgent;
        $saleDto->isBot = $this->userAgent->checkIsBot($userAgent);
        $sale->create($saleDto);
        $referralCode = env('REFERRAL_CODE');
        $domain = env('APP_URL');
        return redirect(
            "https://www.oplata.info/asp2/pay_wm.asp?id_d=$id&id_po=0&ai=$referralCode&" .
            "curr=WMR&failpage=$domain/products/$id&lang=ru-RU&nocash=973411"
        );
    }
}
