<?php

namespace Core\Controller\Console\System;

use Core\Controller\Console\BaseController;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Doctrine\ORM\EntityManagerInterface;
use Core\Console\ConsoleTrait;

class DoctrineController extends BaseController
{

    use ConsoleTrait;

    public function indexAction(EntityManagerInterface $entityManager): void
    {

        unset($_SERVER['argv'][1]);

        ConsoleRunner::run(
                new SingleManagerProvider($entityManager)
        );
    }
}
