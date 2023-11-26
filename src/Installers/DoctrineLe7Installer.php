<?php

namespace Core\Installers;

use Composer\Installer\PackageEvent;

class DoctrineLe7Installer
{

    public static function postPackageInstall(PackageEvent $event)
    {
        
        $installedPackage = $event->getOperation()->getPackage();
        echo $installedPackage . ' setup';
        
        $sourceConfigFile = __DIR__ . '/../../dist/db_doctrine.php';
        $sourceContainerConfigFile = __DIR__ . '/../../dist/dbDoctrineContainerConf.php';
        $destinationConfigDirectory = __DIR__ . '/../../../../../config';
        $destinationContainerDirectory = __DIR__ . '/../../../../../container';
        $destinationConfigPath = $destinationConfigDirectory . '/db_doctrine.php';
        $destinationContainerConfigPath = $destinationContainerDirectory . '/dbDoctrineContainerConf.php';
        if (!file_exists($destinationConfigPath)) {
            copy($sourceConfigFile, $destinationConfigPath);
        }
        if (!file_exists($destinationContainerConfigPath)) {
            copy($sourceContainerConfigFile, $destinationContainerConfigPath);
        }
    }
}
