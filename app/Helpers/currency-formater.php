<?php

function currencyFormatter($price, $actualPrice=null, $hasOffer = 0){
    if(!is_null($actualPrice) && $hasOffer > 0){
        return 'AED' .' '.$actualPrice.'<em> AED'.$price.'</em>';
    }
    return 'AED' .' '.$price;
}
