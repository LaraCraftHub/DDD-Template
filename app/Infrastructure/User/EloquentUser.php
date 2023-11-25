<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Infrastructure\User\EloquentUser
 *
 * @method static Builder|EloquentUser newModelQuery()
 * @method static Builder|EloquentUser newQuery()
 * @method static Builder|EloquentUser query()
 * @method static Builder|EloquentUser onlyTrashed()
 * @method static Builder|EloquentUser withTrashed()
 * @method static Builder|EloquentUser withoutTrashed()
 *
 * @mixin \Eloquent
 */
class EloquentUser extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'immutable_datetime',
        'password' => 'hashed',
    ];
}
