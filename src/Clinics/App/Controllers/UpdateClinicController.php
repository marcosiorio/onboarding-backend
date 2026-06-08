<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Requests\UpsertClinicRequest;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Actions\UpsertClinicAction;
use Lightit\Clinics\Domain\Models\Clinic;

final readonly class UpdateClinicController
{
    public function __invoke(
        Clinic $clinic,
        UpsertClinicRequest $request,
        UpsertClinicAction $action,
    ): JsonResponse {
        $clinic = $action->execute($request->getName(), $request->getAddress(), $clinic);

        return ClinicResource::make($clinic)
            ->response();
    }
}
