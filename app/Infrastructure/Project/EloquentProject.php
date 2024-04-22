<?php

declare(strict_types=1);

namespace App\Infrastructure\Project;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectStatus;
use App\Domain\User\User;
use App\Domain\UserProject\UserProject;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

/**
 * App\Infrastructure\Project\EloquentProject
 *
 * @method static ProjectFactory factory(callable|array|int|null $count = null, callable|array $state = [])
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project onlyTrashed()
 * @method static Builder|Project query()
 * @method static Builder|Project whereBlockedAt($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDeletedAt($value)
 * @method static Builder|Project whereFunds($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereStartedAt($value)
 * @method static Builder|Project whereStatus($value)
 * @method static Builder|Project whereTerminatedAt($value)
 * @method static Builder|Project whereTitle($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project withTrashed()
 * @method static Builder|Project withoutTrashed()
 *
 * @mixin \Eloquent
 */
class EloquentProject extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array<string, mixed> */
    protected $attributes = [
        'status' => ProjectStatus::GENERATED,
    ];

    /** @var list<string> */
    protected $fillable = [
        'title',
        'status',
        'funds',
        'started_at',
        'blocked_at',
        'terminated_at',
    ];

    /**
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_project',
            'project_id',
            'user_id',
        )->using(UserProject::class);
    }

    protected static function newFactory(): ProjectFactory
    {
        return ProjectFactory::new();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'status' => ProjectStatusCast::class,
            'started_at' => 'immutable_datetime',
            'blocked_at' => 'immutable_datetime',
            'terminated_at' => 'immutable_datetime',
        ];
    }
}
