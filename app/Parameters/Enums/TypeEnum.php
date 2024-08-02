<?php

declare(strict_types=1);

namespace App\Parameters\Enums;

enum TypeEnum: string
{
    case STRING = 'string';
    case INT = 'int';
    case BOOLEAN = 'boolean';
}
