<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Patients\Domain\Models\Patient;

final readonly class DeletePatientController
{
    public function __invoke(Patient $patient): JsonResponse
    {
        $patient->deleteOrFail();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
