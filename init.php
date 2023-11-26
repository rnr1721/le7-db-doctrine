<?php

$conflictFiles = [
    'config/db_redbean.php',
    'container/dbRedbeanConf.php'
];

foreach ($conflictFiles as $conflictFile) {
    if (file_exists($conflictFile)) {
        unlink($conflictFile);
    }
}
