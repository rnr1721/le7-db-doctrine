<?php

namespace Core\Controller\Console\System;

use Core\Controller\Console\BaseController;
use Core\Console\ConsoleTrait;
use Core\Interfaces\ConfigInterface;
use Symfony\Component\Console\Application;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

class DoctrineController extends BaseController
{

    use ConsoleTrait;
    
    public function indexAction():void {
        $this->stdout('Doctrine ORM commands:');
        $this->stdout('This info      : ./cli doctrine');
        $this->stdout('Main commands  : ./cli doctrine:db');
        $this->stdout('Migrations     : ./cli doctrine:migrations');
    }
    
    public function dbAction(EntityManagerInterface $entityManager): void
    {

        unset($_SERVER['argv'][1]);

        ConsoleRunner::run(
                new SingleManagerProvider($entityManager)
        );
    }

    public function migrationsAction(EntityManagerInterface $entityManager, ConfigInterface $config): void
    {

        unset($_SERVER['argv'][1]);

        $configArray = $config->array('doctrine_migrations');

        $connection = $entityManager->getConnection();

        $migrationsConfig = new ConfigurationArray($configArray);

        $dependencyFactory = DependencyFactory::fromConnection($migrationsConfig, new ExistingConnection($connection));

        $cli = new Application('Doctrine Migrations');
        $cli->setCatchExceptions(true);

        $cli->addCommands(array(
            new \Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\DiffCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\ExecuteCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\GenerateCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\LatestCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\ListCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\MigrateCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\RollupCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\StatusCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand($dependencyFactory),
            new \Doctrine\Migrations\Tools\Console\Command\VersionCommand($dependencyFactory),
        ));  
        
        $cli->run();
        
    }
}
