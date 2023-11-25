<?php

declare(strict_types=1);

namespace App\Application\Http\Requests\Project;

use App\Application\Rules\Project\IsValidProjectStatus;
use Illuminate\Foundation\Http\FormRequest;

final class GetUserProjectsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'group_by_status' => ['required', 'boolean'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'status' => [
                'sometimes',
                new IsValidProjectStatus,
            ],
        ];
    }
}
