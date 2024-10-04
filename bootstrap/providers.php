<?php

declare(strict_types=1);

use App\Providers\ControllersServiceProvider;
use App\Providers\FactoriesServiceProvider;
use App\Providers\RepositoriesServiceProvider;

return [
    ControllersServiceProvider::class,
    RepositoriesServiceProvider::class,
    FactoriesServiceProvider::class,
];
