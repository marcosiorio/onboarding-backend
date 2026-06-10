<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpdateAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Models\Appointment;

final readonly class UpdateAppointmentController
{
    public function __invoke(
        Appointment $appointment,
        UpdateAppointmentRequest $request,
        UpsertAppointmentAction $action,
    ): JsonResponse {
        $appointment = $action->execute($request->toDto(), $appointment);

        return AppointmentResource::make($appointment)
            ->response();
    }
}
