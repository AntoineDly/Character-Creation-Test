<?php

declare(strict_types=1);

namespace App\Character\Models;

use Illuminate\Database\Eloquent\Model;

final class Character extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
}
