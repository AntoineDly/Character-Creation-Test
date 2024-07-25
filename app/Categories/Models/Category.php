<?php

declare(strict_types=1);

namespace App\Categories\Models;

use App\Base\Traits\Uuid;
use App\Game\Models\Game;
use App\Parameters\Models\Parameter;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Category extends Model
{
    use Uuid;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the user that created the categorie.
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
        return $this->belongsToMany(Game::class, 'categories_games');
    }

    /**
     * Get the parameters of the category.
     *
     * @return BelongsToMany<Parameter>
     */
    public function parameters(): BelongsToMany
    {
        return $this->belongsToMany(Parameter::class, 'categories_parameters');
    }
}
