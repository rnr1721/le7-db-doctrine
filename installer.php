<?php

$sourceConfigFile = __DIR__ . '/dist/db_doctrine.php';
$sourceContainerConfigFile = __DIR__ . '/dist/dbDoctrineContainerConf.php';
$destinationConfigDirectory = __DIR__ . '/../../../config';
$destinationContainerDirectory = __DIR__ . '/../../../container';
$destinationConfigPath = $destinationConfigDirectory . '/config.php';
$destinationContainerConfigPath = $destinationContainerDirectory . '/dbDoctrineContainerConf.php';
if (!file_exists($destinationConfigPath)) {
    copy($sourceConfigFile, $destinationConfigPath);
}
if (!file_exists($destinationContainerConfigPath)) {
    copy($sourceContainerConfigFile, $destinationContainerConfigPath);
}
