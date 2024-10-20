<?php

declare(strict_types=1);

namespace App\Shared\Repositories\AbstractRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract readonly class AbstractRepository implements AbstractRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * @return Collection<int, Model>
     */
    public function index(): Collection
    {
        return $this->model->all();
    }

    public function findById(string $id): ?Model
    {
        return $this->findByAttribute(column: 'id', value: $id);
    }

    public function findByAttribute(string $column, mixed $value): ?Model
    {
        return $this->model->query()->firstWhere(column: $column, operator: '=', value: $value);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): void
    {
        $this->model->query()->create($attributes);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(string $key, mixed $value, array $attributes): ?bool
    {
        return $this->model->query()->where($key, $value)->sole()->update($attributes);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updateById(string $id, array $attributes): ?bool
    {
        return $this->model->query()->where('id', $id)->sole()->update($attributes);
    }
}
