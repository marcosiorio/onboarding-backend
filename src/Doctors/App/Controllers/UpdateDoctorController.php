<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Requests\UpsertDoctorRequest;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Actions\UpsertDoctorAction;
use Lightit\Doctors\Domain\Models\Doctor;

final readonly class UpdateDoctorController
{
    public function __invoke(
        Doctor $doctor,
        UpsertDoctorRequest $request,
        UpsertDoctorAction $action,
    ): JsonResponse {
        $doctor = $action->execute($request->getName(), $doctor);

        return DoctorResource::make($doctor)
            ->response();
    }
}
