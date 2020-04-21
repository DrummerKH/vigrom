<?php
/**
 * LLC "UTS"
 * Dmitry Hvorostyuk <d.hvorostyuk@hotelbook.ru>
 * Date: 20.04.2020
 */

namespace App\Service\CurrencyRatesProvider;

use App\Entity\Rates;
use App\Repository\CurrencyRepository;
use DateTime;
use Exception;
use Generator;

class RatesDummyProvider implements RatesProviderInterface
{
    private CurrencyRepository $currencyRepository;

    const MUL = 1000000;

    const RATES = [
        'USD' => [1, 1],
        'EUR' => [0.8, 0.99],
        'RUB' => [70, 75]
    ];

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return Generator
     * @throws Exception
     */
    public function getRates(): Generator
    {
        foreach (self::RATES as $currency => $rates) {
            $c = $this->currencyRepository->findOneBy(['code' => $currency]);
            yield (new Rates())
                ->setCurrency($c)
                ->setDate(new DateTime())
                ->setRate(
                    rand(
                        $rates[0] * self::MUL,
                        $rates[1] * self::MUL
                    ) / self::MUL
                );
        }
    }
}