<?php

namespace Core\Factories;

use Core\Interfaces\DoctrineEntityManagerFactoryInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use \InvalidArgumentException;

/**
 * The DoctrineEntityManagerFactory class implements
 * DoctrineEntityManagerFactoryInterface providing methods to create a Doctrine
 * EntityManager instance and manage its settings.
 */
class DoctrineEntityManagerFactory implements DoctrineEntityManagerFactoryInterface
{

    private bool $isDevMode = true;
    private array $paths = [];

    /**
     * @inheritdoc
     */
    public function getEntityManager(
            array $connectionData,
    ): EntityManagerInterface
    {
        $paths = $this->paths;

        if (empty($paths)) {
            $paths = [
                __DIR__ . "/Models"
            ];
        }

        foreach ($paths as $path) {
            if (!is_dir($path)) {
                throw new InvalidArgumentException("Model path does not exist: $path");
            }
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
                        paths: $paths,
                        isDevMode: $this->isDevMode,
        );

        $connection = DriverManager::getConnection($connectionData, $config);

        try {
            return new EntityManager($connection, $config);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to create EntityManager: " . $e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public function setIsDevMode(bool $devModeState): self
    {
        $this->isDevMode = $devModeState;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPaths(string|array $paths): self
    {
        if (is_string($paths)) {
            $this->paths[] = $paths;
        } else {
            $this->paths = array_merge($this->paths, $paths);
        }
        return $this;
    }
}
