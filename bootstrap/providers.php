<?php

declare(strict_types=1);

use App\Providers\ControllersServiceProvider;
use App\Providers\PassportServiceProvider;
use App\Providers\RepositoriesServiceProvider;
use App\Providers\RoutesServiceProvider;

return [
    ControllersServiceProvider::class,
    RepositoriesServiceProvider::class,
    PassportServiceProvider::class,
    RoutesServiceProvider::class,
];
