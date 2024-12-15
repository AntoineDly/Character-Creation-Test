<?php

declare(strict_types=1);

namespace App\Categories\Models;

use App\Components\Models\Component;
use App\Games\Models\Game;
use App\Shared\Traits\HasModelFactory;
use App\Shared\Traits\Uuid;
use App\Users\Models\User;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Category extends Model
{
    /** @use HasModelFactory<CategoryFactory> */
    use HasModelFactory, Uuid;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the user that created the category.
     *
     * @return BelongsTo<User, Category>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the games with this category.
     *
     * @return BelongsToMany<Game>
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withTimestamps();
    }

    /**
     * Get the components of the category.
     *
     * @return BelongsToMany<Component>
     */
    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Component::class)->withTimestamps();
    }
}
