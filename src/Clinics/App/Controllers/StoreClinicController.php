<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Requests\UpsertClinicRequest;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Actions\StoreClinicAction;

final readonly class StoreClinicController
{
    #[Endpoint(
        operationId: 'storeClinic',
        title: 'Store a clinic',
        description: 'Store a new clinic data',
    )]
    public function __invoke(UpsertClinicRequest $request, StoreClinicAction $action): JsonResponse
    {
        $clinic = $action->execute((string) $request->getName(), (string) $request->getAddress());

        return ClinicResource::make($clinic)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
