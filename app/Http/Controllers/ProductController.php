<?php

namespace App\Http\Controllers;

use App\Models\Plati;
use App\Models\Sale;
use App\Models\SaleDto;
use App\Models\UserAgent;
use App\View\ProductView;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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

    /**
     * @throws GuzzleException
     */
    public function product(int $id, Plati $plati): View|Factory|RedirectResponse
    {
        $product = $plati->getProduct($id);

        if (empty((string)$product->available_goods)) {
            return redirect('/');
        }

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

    public function buy(Request $request): Redirector|RedirectResponse
    {
        $id = (int)$request->input('product');
        $userAgent = $request->userAgent();
        $sale = new Sale();
        $saleDto = new SaleDto();
        $saleDto->product = $id;
        $saleDto->ip = $request->ip();
        $saleDto->userAgent = $userAgent;
        $saleDto->isBot = $this->userAgent->checkIsBot((string)$userAgent);
        $sale->create($saleDto);
        $referralCode = env('REFERRAL_CODE');
        $domain = env('APP_URL');
        return redirect(
            "https://www.oplata.info/asp2/pay_wm.asp?id_d=$id&id_po=0&ai=$referralCode&" .
            "curr=WMR&failpage=$domain/products/$id&lang=ru-RU&nocash=973411"
        );
    }
}
