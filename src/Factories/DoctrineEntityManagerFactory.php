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
    private string $annotationsPath = '';

    /**
     * @inheritdoc
     */
    public function getEntityManager(
            array $connectionData,
    ): EntityManagerInterface
    {
        $annotationsPath = $this->annotationsPath;

        if (empty($annotationsPath)) {
            $annotationsPath = __DIR__ . "/Models";
        }

        if (!is_dir($annotationsPath)) {
            throw new InvalidArgumentException("Model path does not exist: $annotationsPath");
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
                        paths: array($this->annotationsPath),
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
    public function setAnnotationsPath(string $annotationsPath): self
    {
        $this->annotationsPath = $annotationsPath;
        return $this;
    }
}
