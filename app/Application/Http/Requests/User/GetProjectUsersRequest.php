<?php

declare(strict_types=1);

namespace App\Application\Http\Requests\User;

use App\Domain\Project\Project;
use App\Domain\User\User;
use Illuminate\Foundation\Http\FormRequest;

final class GetProjectUsersRequest extends FormRequest
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
        /** @var Project $project */
        $project = $this->route('project');

        /** @var User $user */
        $user = $project->users->first();

        return [
            'project_title' => ['sometimes', 'max:20', 'unique:projects,title,' . $project->id],
            'email' => [
                'sometimes',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
        ];
    }
}
