<?php

declare(strict_types=1);

namespace App\Shared\Domain\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @template TFactory of Factory
 */
trait HasModelFactory
{
    /** @use HasFactory<TFactory> */
    use HasFactory;

    /**
     * Creates a new factory instance for the model.
     *
     * @return TFactory
     */
    protected static function newFactory(): Factory
    {
        /** @var class-string<TFactory> $factoryClass */
        $factoryClass = static::resolveFactoryClass();

        return $factoryClass::new();
    }

    protected static function resolveFactoryClass(): string
    {
        return 'Database\\Factories\\'.class_basename(static::class).'Factory';
    }
}
