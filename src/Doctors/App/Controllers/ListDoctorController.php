<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Actions\ListDoctorAction;

class ListDoctorController
{
    #[Endpoint(
        operationId: 'listDoctors',
        title: 'List doctors',
        description: 'Retrieves a list of doctors.'
    )]
    public function __invoke(
        ListDoctorAction $action,
    ): JsonResponse {
        $doctors = $action->execute();

        return DoctorResource::collection($doctors)->response();
    }
}
