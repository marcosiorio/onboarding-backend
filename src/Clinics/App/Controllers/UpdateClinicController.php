<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Requests\UpsertClinicRequest;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Actions\UpdateClinicAction;
use Lightit\Clinics\Domain\Models\Clinic;

final readonly class UpdateClinicController
{
    public function __invoke(
        Clinic $clinic,
        UpsertClinicRequest $request,
        UpdateClinicAction $action,
    ): JsonResponse {
        $clinic = $action->execute($clinic, $request->getName(), $request->getAddress());

        return ClinicResource::make($clinic)
            ->response();
    }
}
