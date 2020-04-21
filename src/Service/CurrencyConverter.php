<?php


namespace App\Service;


use App\Entity\Currency;
use App\Repository\RatesRepository;
use LogicException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CurrencyConverter
{
    private RatesRepository $ratesRepository;
    private ParameterBagInterface $parameterBag;

    public function __construct(RatesRepository $ratesRepository, ParameterBagInterface $parameterBag)
    {
        $this->ratesRepository = $ratesRepository;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param int $amount
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     * @return int
     */
    public function convert(int $amount, Currency $baseCurrency, Currency $targetCurrency): int
    {
        if ($baseCurrency === $targetCurrency) {
            return $amount;
        }

        $amount *= $this->getRate($baseCurrency, $targetCurrency);

        return round($amount);
    }

    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     * @return float
     */
    private function getRate(Currency $baseCurrency, Currency $targetCurrency): float
    {
        $baseRate = (float)$this->ratesRepository->getLastRateByCurrency($baseCurrency)[0]['rate'] ?? null;
        $targetRate = (float)$this->ratesRepository->getLastRateByCurrency($targetCurrency)[0]['rate'] ?? null;

        if (null === $baseRate || null === $targetRate) {
            throw new LogicException('Currency rate not available');
        }

        if ($this->parameterBag->get('base_currency') === $baseCurrency->getCode()) {
            return $targetRate;
        } else {
            return $targetRate / $baseRate;
        }
    }
}