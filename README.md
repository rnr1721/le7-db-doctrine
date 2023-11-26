# le7-db-doctrine

This package integrate Doctrine ORM into le7 PHP MVC engine.

## Setup
You need to setup database connection in ./config/db_doctrine.php file

## Using in controllers
You will can inject into your controllers EntityManagerInterface

```php
<?php

namespace App\Controller\Web;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    public function indexAction(EntityManagerInterface): ResponseInterface
    {   

        // Use Entity Manager

    }

}
```

## Doctrine command line tool

You can use doctrine command-line tool this way

```bash
./cli.sh doctrine <doctrine options>
```
