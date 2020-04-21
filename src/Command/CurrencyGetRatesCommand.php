<?php

namespace App\Command;

use App\Service\CurrencyRatesProvider\RatesProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CurrencyGetRatesCommand extends Command
{
    protected static $defaultName = 'currency:get-rates';

    private RatesProviderInterface $ratesProvider;
    private EntityManagerInterface $entityManager;

    public function __construct(RatesProviderInterface $ratesProvider, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->ratesProvider = $ratesProvider;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Get currency rates');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->ratesProvider->getRates() as $rate) {
            $this->entityManager->persist($rate);
        }
        $this->entityManager->flush();

        $io->success('Done!');

        return 0;
    }
}
