<?php

namespace App\View;

class SellerView
{
    public function getSellerImage(int $rating): string
    {
        $sellerScore = floor(($rating / 50) + 1);
        $sellerScore = $sellerScore > 3 ? 3 : $sellerScore;
        $sellerScore = $rating < 10 ? 0 : $sellerScore;

        return "/img/icon-merchant-$sellerScore.png";
    }
}