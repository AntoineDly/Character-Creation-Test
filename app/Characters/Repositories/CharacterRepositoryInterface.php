<?php

declare(strict_types=1);

namespace App\Characters\Repositories;

use App\Characters\Models\Character;
use App\Shared\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<Character>
 */
interface CharacterRepositoryInterface extends RepositoryInterface
{
    public function getCharacterWithLinkedItemsById(string $id): Character;

    public function getCharacterWithGameById(string $id): Character;
}
