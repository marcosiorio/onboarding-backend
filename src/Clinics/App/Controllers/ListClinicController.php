<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Actions\ListClinicAction;

final readonly class ListClinicController
{
    #[Endpoint(
        operationId: 'listClinics',
        title: 'List clinics',
        description: 'Retrieves a list of clinics.'
    )]
    public function __invoke(ListClinicAction $action): JsonResponse
    {
        $clinics = $action->execute();

        return ClinicResource::collection($clinics)->response();
    }
}
