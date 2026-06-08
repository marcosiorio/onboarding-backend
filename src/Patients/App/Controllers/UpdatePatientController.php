<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Patients\App\Requests\UpsertPatientRequest;
use Lightit\Patients\App\Resources\PatientResource;
use Lightit\Patients\Domain\Actions\UpsertPatientAction;
use Lightit\Patients\Domain\Models\Patient;

final readonly class UpdatePatientController
{
    public function __invoke(
        Patient $patient,
        UpsertPatientRequest $request,
        UpsertPatientAction $action,
    ): JsonResponse {
        $patient = $action->execute($request->getName(), $request->getEmail(), $patient);

        return PatientResource::make($patient)
            ->response();
    }
}
