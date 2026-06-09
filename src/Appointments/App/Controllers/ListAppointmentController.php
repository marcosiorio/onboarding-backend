<?php

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\ListAppointmentAction;

final readonly class ListAppointmentController
{
    public function __invoke(ListAppointmentAction $action): JsonResponse
    {
        $appointment = $action->execute();

        return AppointmentResource::collection($appointment)
                ->response();
    }
}
