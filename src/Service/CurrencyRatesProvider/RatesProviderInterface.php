<?php

namespace App\Service\CurrencyRatesProvider;

use Generator;

interface RatesProviderInterface
{
    public function getRates(): Generator;
}