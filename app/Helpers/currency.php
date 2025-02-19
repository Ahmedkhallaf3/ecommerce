<?php

namespace app\Helpers;

use NumberFormatter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Currency{
// هنا عملنا ميثوت عشان العملات اذا كانت بالدولار او الجنية او اي عملة
// public static function format($amount,$currency=null){
// $formatter= new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
// if($currency===null){
// $currency=config('app.currency','USD');
// }
// return $formatter->formatCurrency($amount,$currency);

  public static function format($amount, $currency = null)
    {
        $baseCurrency = config('app.currency', 'USD');

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

        if ($currency === null) {
            $currency = Session::get('currency_code', $baseCurrency);
        }

        if ($currency != $baseCurrency) {
            $rate = Cache::get('currency_rate_' . $currency, 1);
            $amount = $amount * $rate;
        }

        return $formatter->formatCurrency($amount, $currency);

}

}
