<?php

namespace Core\Controller\Console;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Doctrine\ORM\EntityManagerInterface;
use Core\Console\ConsoleTrait;

class DoctrineController
{

    use ConsoleTrait;

    public function indexAction(EntityManagerInterface $entityManager): void
    {
        ConsoleRunner::run(
                new SingleManagerProvider($entityManager)
        );
    }
}
