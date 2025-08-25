<?php

declare(strict_types=1);

namespace App\Characters\Infrastructure\Repositories;

use App\Characters\Domain\Models\Character;
use App\Shared\Infrastructure\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<Character>
 */
interface CharacterRepositoryInterface extends RepositoryInterface
{
    public function getCharacterWithLinkedItemsById(string $id): Character;

    public function getCharacterWithGameById(string $id): Character;
}
