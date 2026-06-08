<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Models\Clinic;

final readonly class GetClinicController
{
    #[Endpoint(
        operationId: 'getClinic',
        title: 'Get a single clinic',
        description: 'Retrieves a clinic by its ID.'
    )]
    public function __invoke(Clinic $clinic): JsonResponse
    {
        return ClinicResource::make($clinic)
            ->response();
    }
}
