<?php

declare(strict_types=1);

namespace App\Application\Rules\Project;

use App\Domain\Project\Project;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Override;

use function in_array;

class IsValidProjectStatus implements DataAwareRule, ValidationRule
{
    /** @var array<string, mixed> */
    protected array $data = [];

    /**
     * @param Closure(string):PotentiallyTranslatedString $fail
     */
    #[Override]
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->passes($value)) {
            return;
        }

        $fail($this->failMessage());
    }

    /**
     * Set the data under validation.
     *
     * @param array<string, mixed> $data
     */
    #[Override]
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    private function passes(mixed $value): bool
    {
        return in_array($value, Project::STATUSES, true);
    }

    private function failMessage(): string
    {
        return trans('custom_validation.project.status.invalid');
    }
}
