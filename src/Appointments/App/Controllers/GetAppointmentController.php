<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Models\Appointment;

final readonly class GetAppointmentController
{
    #[Endpoint(
        operationId: 'getAppointment',
        title: 'Get a single appointment',
        description: 'Retrieves an appointment.'
    )]
    public function __invoke(
        Appointment $appointment,
    ): JsonResponse {
        return AppointmentResource::make($appointment)
            ->response();
    }
}
