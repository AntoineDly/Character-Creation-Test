<?php

declare(strict_types=1);

namespace App\Shared\Collection;

use ArrayIterator;

/**
 * @template T
 */
trait CollectionTrait
{
    /** @var T[] */
    private array $elements;

    public static function createEmpty(): static
    {
        return new static([]);
    }

    /** @param mixed[] $elements */
    public static function fromMap(array $elements, callable $fn): static
    {
        return new static(array_map($fn, $elements));
    }

    /**
     * @param  T  $initial
     * @return T
     */
    public function reduce(callable $fn, mixed $initial): mixed
    {
        return array_reduce($this->elements, $fn, $initial);
    }

    /** @return mixed[] */
    public function map(callable $fn): array
    {
        return array_map($fn, $this->elements);
    }

    public function each(callable $fn): void
    {
        array_walk($this->elements, $fn);
    }

    public function some(callable $fn): bool
    {
        foreach ($this->elements as $index => $element) {
            if ($fn($element, $index, $this->elements)) {
                return true;
            }
        }

        return false;
    }

    public function filter(callable $fn): static
    {
        return new static(array_filter($this->elements, $fn, ARRAY_FILTER_USE_BOTH));
    }

    public function filterKey(callable $fn): static
    {
        return new static(array_filter($this->elements, $fn, ARRAY_FILTER_USE_KEY));
    }

    /** @return T|false */
    public function first(): mixed
    {
        return reset($this->elements);
    }

    public function last(): mixed
    {
        return end($this->elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    /** @param T $element */
    public function add(mixed $element, mixed $offset = null): static
    {
        $this->offsetSet($offset, $element);

        return $this;
    }

    /** @return T[] */
    public function values(): array
    {
        return array_values($this->elements);
    }

    /** @return T[] */
    public function elements(): array
    {
        return $this->elements;
    }

    /** @return ArrayIterator<int, T> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->elements[$offset]);
    }

    /**
     * @return T|null
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->elements[$offset] ?? null;
    }

    /**
     * @param  T  $element
     */
    public function offsetSet(mixed $offset, mixed $element): void
    {
        if (is_null($offset)) {
            $this->elements[] = $element;
        } else {
            $this->elements[$offset] = $element;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->elements[$offset]);
    }

    /**
     * @return array<int, T>
     */
    public function all(): array
    {
        return $this->elements;
    }

    /** @return T[] */
    public function __serialize(): array
    {
        return $this->elements;
    }

    /** @param T[] $elements */
    public function __unserialize(array $elements): void
    {
        $this->elements = $elements;
    }

    /** @return T[] */
    public function jsonSerialize(): mixed
    {
        return $this->elements;
    }
}
