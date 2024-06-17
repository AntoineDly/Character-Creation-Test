<?php

declare(strict_types=1);

namespace App\Base\Repositories\AbstractRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AbstractRepositoryInterface
{
    /**
     * @return Collection<int, Model>
     */
    public function index(): Collection;

    public function findById(int $id): ?Model;

    public function findByAttribute(string $column, mixed $value): ?Model;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): void;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array $attributes): void;
}
