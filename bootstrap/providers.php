<?php

declare(strict_types=1);

use App\Providers\ControllersServiceProvider;
use App\Providers\PassportServiceProvider;
use App\Providers\RepositoriesServiceProvider;

return [
    ControllersServiceProvider::class,
    RepositoriesServiceProvider::class,
    PassportServiceProvider::class,
];
