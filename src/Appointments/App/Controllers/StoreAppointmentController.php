<?php

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;

final readonly class StoreAppointmentController
{
    public function __invoke(
        UpsertAppointmentRequest $request,
        UpsertAppointmentAction $action,
    ): JsonResponse {
        $appointment = $action->execute($request->toDto());

        return AppointmentResource::make($appointment)
                ->response()->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
