<?php

namespace Core\Interfaces;

use Doctrine\ORM\EntityManagerInterface;

/**
 * The DoctrineEntityManagerFactoryInterface defines methods for creating
 * a Doctrine EntityManager instance and managing its settings.
 */
interface DoctrineEntityManagerFactoryInterface
{

    /**
     * The getEntityManager method creates and returns an instance of the
     * Doctrine EntityManager with settings based on the provided parameters.
     *
     * @param array $connectionData The Doctrine array with server params
     *
     * @return EntityManagerInterface The instance of Doctrine EntityManager.
     */
    public function getEntityManager(
            array $connectionData,
    ): EntityManagerInterface;

    /**
     * The setIsDevMode method sets the development mode for the
     * EntityManagerFactory.
     *
     * @param bool $devModeState The state of the development mode
     * (true - development mode enabled, false - disabled).
     *
     * @return self
     */
    public function setIsDevMode(bool $devModeState): self;

    /**
     * The setAnnotationsPath method sets the paths to the directory containing
     * entities.
     *
     * @param string|array $paths The path to the directory containing entity annotations.
     *
     * @return self
     */
    public function setPaths(string|array $paths): self;
}
