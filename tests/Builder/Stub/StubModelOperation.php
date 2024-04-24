<?php

declare(strict_types=1);

namespace Tests\Builder\Stub;

use App\Alias\SupportCollection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;

use function array_key_exists;

/**
 * @template StubModel
 */
trait StubModelOperation
{
    /**
     * @param array<string, bool> $options
     */
    public function save(array $options = []): bool
    {
        return true;
    }

    /**
     * @param array<string, mixed> $attributes
     * @param array<string, bool> $options
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        if (! array_key_exists('updated_at', $attributes)) {
            $this->setAttribute('updated_at', now()->addSeconds(5));
        }

        foreach ($attributes as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }

        return true;
    }

    /**
     * @param array<array-key, (callable(EloquentBuilder<StubModel>): mixed)|string>|string $relations
     */
    public function load($relations): self
    {
        return $this;
    }

    /**
     * @param array<array-key, (callable(EloquentBuilder<StubModel>): mixed)|string>|string $relations
     */
    public function loadMissing($relations): self
    {
        return $this;
    }

    /**
     * @param array<array-key, string>|string $with
     */
    public function fresh($with = []): self
    {
        return $this;
    }

    public function refresh(): self
    {
        return $this;
    }

    public function delete(): bool
    {
        $this->attributes['deleted_at'] = now();

        return true;
    }

    /**
     * @param SupportCollection<int, StubModel> $expectedValue
     * @return HasMany<StubModel>
     */
    public function mockHasMany(SupportCollection $expectedValue): HasMany
    {
        $eloquentBuilder = Mockery::spy(EloquentBuilder::class);

        $eloquentBuilder->shouldReceive('getModel')->andReturn($this);
        $eloquentBuilder->shouldReceive('where')->andReturn($eloquentBuilder);
        $eloquentBuilder->shouldReceive('WhereNotNull')->andReturn($eloquentBuilder);

        $eloquentBuilder->shouldReceive('get')->andReturn($expectedValue);
        $eloquentBuilder->shouldReceive('first')->andReturn($expectedValue->first());

        return $this->newHasMany($eloquentBuilder, $this, '', '');
    }

    /**
     * @param SupportCollection<int, StubModel> $expectedValue
     * @return BelongsToMany<StubModel>
     */
    public function mockBelongsToMany(SupportCollection $expectedValue): BelongsToMany
    {
        $eloquentBuilder = Mockery::spy(EloquentBuilder::class);

        $eloquentBuilder->shouldReceive('getModel')->andReturn($this);
        $eloquentBuilder->shouldReceive('applyScopes')->andReturn($eloquentBuilder);
        $eloquentBuilder->shouldReceive('getQuery')->andReturn($this);
        $eloquentBuilder->shouldReceive('addSelect')->andReturn($eloquentBuilder);
        $eloquentBuilder->shouldReceive('getModels')->andReturn($expectedValue->all());
        $eloquentBuilder->shouldReceive('eagerLoadRelations')->andReturn($expectedValue->all());

        $eloquentBuilder->shouldReceive('join')->andReturn();
        $eloquentBuilder->shouldReceive('take')->andReturn($eloquentBuilder);
        $eloquentBuilder->shouldReceive('where')->andReturn($eloquentBuilder);

        return $this->newBelongsToMany($eloquentBuilder, $this, '', '', '', '', '');
    }
}
