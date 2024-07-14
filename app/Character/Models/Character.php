<?php

declare(strict_types=1);

namespace App\Character\Models;

use App\Base\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

final class Character extends Model
{
    use Uuid;

    protected $fillable = [
        'name',
    ];
}
