<?php

declare(strict_types=1);

namespace App\Application\Http\Controllers\Api\User;

use App\Application\Http\Controllers\Controller;
use App\Application\Http\Requests\User\GetProjectUsersRequest;
use App\Domain\Project\Project;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetProjectUsersController extends Controller
{
    public function __invoke(Project $project, GetProjectUsersRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'results' => $project->users,
                'nb_results' => $project->users->count(),
            ],
            Response::HTTP_OK,
        );
    }
}
