<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Patients\Domain\Actions\DeletePatientAction;
use Lightit\Patients\Domain\Models\Patient;

final readonly class DeletePatientController
{
    public function __invoke(Patient $patient, DeletePatientAction $action): JsonResponse
    {
        $action->execute($patient);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
