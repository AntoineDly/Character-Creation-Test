<?php

declare(strict_types=1);

namespace App\Parameters\Enums;

enum TypeParameterEnum: string
{
    case STRING = 'string';
    case INT = 'int';
    case BOOLEAN = 'boolean';
}
