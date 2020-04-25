<?php

namespace App\Http\Controllers;

use App\Models\Plati;
use Cache;
use Meta;

class SellerController extends Controller
{
    public function index(Plati $plati, int $id)
    {
        /**
        id = params[:id].to_i

        hash = {id_seller: id}
        xml = create_xml hash

        uri = URI(PLATI_URL)
        Net::HTTP.start(uri.host, uri.port, :use_ssl => uri.scheme == 'https') do |http|
        @response = http.post("/xml/seller_info.asp", xml, initheader = {'Content-Type' =>'text/xml'})
        end

        converted_response_body = @response.body.scrub
        @data = Nokogiri::XML(converted_response_body)

        #responses
        hash = {id_seller: id, rows: 100}
        xml = create_xml hash
        Net::HTTP.start(uri.host, uri.port, :use_ssl => uri.scheme == 'https') do |http|
        @response = http.post("/xml/responses.asp", xml, initheader = {'Content-Type' =>'text/xml'})
        end

        converted_response_body = @response.body.scrub
        @response_data = Nokogiri::XML(converted_response_body)
        @responses = []
        @response_data.css('rows').css('row').each do |row|
        @responses.push(row)
        end
        #responses

        prepare_meta_tags title: "Продавец #{@data.css('name_seller').text}"
         */

        $sellerInfo = $plati->getSellerInfo($id);

        Meta::set('title', 'Продавец' . $sellerInfo->{'name_seller'} . ' | SellerStore.ru');

        return view('seller.index', compact('sellerInfo'));
    }

    public function goods(Plati $plati, int $id)
    {
//        $productsData = Cache::remember("seller-goods-$id", now()->addHours(24), function () use($plati, $id) {
//            return $plati->getSellerGoods($id);
//        });
        $productsData = $plati->getSellerGoods($id);
        $products = $productsData->{'rows'}->{'row'};
        return view('seller.goods', compact('products'));
    }

    public function responses(Plati $plati, int $id)
    {
        $responses = $plati->getResponses($id);

        return view('seller.responses', compact('responses'));

    }
}
