<?php

declare(strict_types=1);

namespace App\Shared\Repositories\AbstractRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AbstractRepositoryInterface
{
    /**
     * @return Collection<int, Model>
     */
    public function index(): Collection;

    public function findById(string $id): ?Model;

    public function findByAttribute(string $column, mixed $value): ?Model;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): void;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(string $key, mixed $value, array $attributes): ?bool;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updateById(string $id, array $attributes): ?bool;
}
