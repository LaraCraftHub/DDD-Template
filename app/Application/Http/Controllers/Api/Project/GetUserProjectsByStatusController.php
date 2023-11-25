<?php

declare(strict_types=1);

namespace App\Application\Http\Controllers\Api\Project;

use App\Application\Http\Controllers\Controller;
use App\Application\Http\Requests\Project\GetUserProjectsRequest;
use App\Domain\Project\Actions\GetUserProjectsGroupedByStatus;
use App\Domain\User\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetUserProjectsByStatusController extends Controller
{
    public function __construct(private readonly GetUserProjectsGroupedByStatus $getUserProjectsGroupedByStatus)
    {
    }

    public function __invoke(User $user, GetUserProjectsRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'results' => $request->get('group_by_status') === true
                    ? ($this->getUserProjectsGroupedByStatus)($user)
                    : $user->projects()->withTrashed()->get(),
                'nb_results' => 1,
            ],
            Response::HTTP_OK,
        );
    }
}
