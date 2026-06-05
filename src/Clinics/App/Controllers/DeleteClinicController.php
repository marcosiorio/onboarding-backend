<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\Domain\Actions\DeleteClinicAction;
use Lightit\Clinics\Domain\Models\Clinic;

final readonly class DeleteClinicController
{
    public function __invoke(Clinic $clinic, DeleteClinicAction $action): JsonResponse
    {
        $action->execute($clinic);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
