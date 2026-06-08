<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\Domain\Models\Clinic;

final readonly class DeleteClinicController
{
    public function __invoke(Clinic $clinic): JsonResponse
    {
        $clinic->deleteOrFail();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
