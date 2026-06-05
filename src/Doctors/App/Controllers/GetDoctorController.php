<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Models\Doctor;

final readonly class GetDoctorController
{
    #[Endpoint(
        operationId: 'getDoctor',
        title: 'Get a single doctor',
        description: 'Retrieves a doctor by its ID.'
    )]
    public function __invoke(Doctor $doctor): JsonResponse
    {
        return DoctorResource::make($doctor)
            ->response();
    }
}
