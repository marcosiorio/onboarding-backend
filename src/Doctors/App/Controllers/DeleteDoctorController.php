<?php

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Actions\DeleteDoctorAction;
use Lightit\Doctors\Domain\Models\Doctor;

final readonly class DeleteDoctorController
{
    public function __invoke(
        Doctor $doctor,
        DeleteDoctorAction $action,

    ): JsonResponse {
        $doctor = $action->execute($doctor);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
