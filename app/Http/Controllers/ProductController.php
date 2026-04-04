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
    public function __construct(private readonly UserAgent $userAgent)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function product(string $id, Plati $plati): View|Factory|RedirectResponse
    {
        $id = $this->normalizeProductId($id);
        if ($id === null) {
            abort(404);
        }

        /** @var list<string> $idsToRedirect */
        $idsToRedirect = config('site.blocked_product_ids', []);
        if (in_array((string) $id, $idsToRedirect, true)) {
            return redirect('/');
        }

        $product = $plati->getProduct($id);

        /**transformations**/
        $wmr = $product->{'price_goods'}->wmr ?? null;
        if (isset($wmr) && $wmr > 0) {
            $product->{'price'} = $wmr;
            $product->{'currency'} = '₽';
        } else {
            $product->{'price'} = $product->{'price_goods'}->wmz ?? 0;
            $product->{'currency'} = '$';
        }
        /**transformations**/

        $productHelper = new ProductView();
        $title = $productHelper->prepareDescription($product->{'name_goods'});
        $keywords = 'купить ключ ' . $title;
        Meta::set('title', "Купить $title" . ' | SellerStore.ru');
        Meta::set('description', "Купить $title");
        Meta::set('keywords', $keywords);

        $responses = $plati->getResponses((int)$product->{'id_seller'}, $id);

        /** @var view-string $view */
        $view = 'product.product';

        return view($view, compact('product', 'responses'));
    }

    private function normalizeProductId(string $id): ?int
    {
        if (!preg_match('/^\d+/', $id, $matches)) {
            return null;
        }

        return (int) $matches[0];
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
        $referralCode = (string) config('site.referral_code', '');
        $domain = (string) config('app.url', '');
        return redirect(
            "https://www.oplata.info/asp2/pay_wm.asp?id_d=$id&id_po=0&ai=$referralCode&" .
            "curr=WMR&failpage=$domain/products/$id&lang=ru-RU&nocash=973411"
        );
    }
}
