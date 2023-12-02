<?php

use Doctrine\ORM\EntityManagerInterface;
use Core\Interfaces\ConfigInterface;
use Core\Interfaces\DoctrineEntityManagerFactoryInterface;
use Core\Factories\DoctrineEntityManagerFactory;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    DoctrineEntityManagerFactoryInterface::class => factory(function () {
        return new DoctrineEntityManagerFactory();
    }),
    EntityManagerInterface::class => factory(function (ContainerInterface $c) {
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);

        $connectData = $config->array('doctrine_config') ?? [];
        $pathsCustom = array_values($config->arrayWithKeyStartWith('doctrine_paths_'));
        
        /** @var DoctrineEntityManagerFactoryInterface $entityManagerFactory */
        $entityManagerFactory = $c->get(DoctrineEntityManagerFactoryInterface::class);

        $isProduction = $config->bool('isProduction') ?? false;
        
        $entityManagerFactory->setIsDevMode(!$isProduction);

        $entityManagerFactory->setPaths($pathsCustom);
        return $entityManagerFactory->getEntityManager($connectData);
    })
];
