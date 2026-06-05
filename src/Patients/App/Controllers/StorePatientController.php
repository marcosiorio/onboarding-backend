<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Patients\App\Requests\UpsertPatientRequest;
use Lightit\Patients\App\Resources\PatientResource;
use Lightit\Patients\Domain\Actions\StorePatientAction;

final readonly class StorePatientController
{
    #[Endpoint(
        operationId: 'storePatient',
        title: 'Store a patient',
        description: 'Store a new patient data',
    )]
    public function __invoke(UpsertPatientRequest $request, StorePatientAction $action): JsonResponse
    {
        $patient = $action->execute((string) $request->getName(), (string) $request->getEmail());

        return PatientResource::make($patient)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
