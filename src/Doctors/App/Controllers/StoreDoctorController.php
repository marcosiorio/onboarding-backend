<?php

namespace Lightit\Doctors\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Requests\UpsertDoctorRequest;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Actions\StoreDoctorAction;

final readonly class StoreDoctorController
{
    #[Endpoint(
        operationId: 'storeDoctor',
        title: 'store a doctor',
        description: 'Store a new doctor data',
    )]
    public function __invoke(UpsertDoctorRequest $request, StoreDoctorAction $action): JsonResponse
    {
        $doctor = $action->execute($request->getName());

        return DoctorResource::make($doctor)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }

}
