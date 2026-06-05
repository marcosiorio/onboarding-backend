<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Patients\App\Requests\UpsertPatientRequest;
use Lightit\Patients\App\Resources\PatientResource;
use Lightit\Patients\Domain\Actions\UpdatePatientAction;
use Lightit\Patients\Domain\Models\Patient;

final readonly class UpdatePatientController
{
    public function __invoke(
        Patient $patient,
        UpsertPatientRequest $request,
        UpdatePatientAction $action,
    ): JsonResponse {
        $patient = $action->execute($patient, $request->getName(), $request->getEmail());

        return PatientResource::make($patient)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
