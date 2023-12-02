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

        $connectData = $config->array('db_doctrine') ?? [];
        $paths = $config->array('db_paths') ?? [];

        /** @var DoctrineEntityManagerFactoryInterface $entityManagerFactory */
        $entityManagerFactory = $c->get(DoctrineEntityManagerFactoryInterface::class);

        $entityManagerFactory->setIsDevMode($config->bool('isProduction') ?? false);

        $entityManagerFactory->setPaths($paths);
        return $entityManagerFactory->getEntityManager($connectData);
    })
];
