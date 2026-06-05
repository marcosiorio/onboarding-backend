<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Requests\UpsertDoctorRequest;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Actions\UpdateDoctorAction;
use Lightit\Doctors\Domain\Models\Doctor;

final readonly class UpdateDoctorController
{
    public function __invoke(
        Doctor $doctor,
        UpsertDoctorRequest $request,
        UpdateDoctorAction $action,
    ): JsonResponse {
        $doctor = $action->execute($doctor, $request->getName());

        return DoctorResource::make($doctor)
            ->response()->setStatusCode(JsonResponse::HTTP_OK);
    }
}
