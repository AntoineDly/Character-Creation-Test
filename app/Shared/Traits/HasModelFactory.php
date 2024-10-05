<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait HasModelFactory
{
    use HasFactory;

    /**
     * Creates a new factory instance for the model.
     *
     * @return Factory<TModel>
     */
    protected static function newFactory(): Factory
    {
        /** @var class-string<Factory<TModel>> $factoryClass */
        $factoryClass = static::resolveFactoryClass();

        return $factoryClass::new();
    }

    protected static function resolveFactoryClass(): string
    {
        return 'Database\\Factories\\'.class_basename(static::class).'Factory';
    }
}
