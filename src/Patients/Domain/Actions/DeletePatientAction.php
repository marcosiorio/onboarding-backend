<?php

declare(strict_types=1);

namespace Lightit\Patients\Domain\Actions;

use Lightit\Patients\Domain\Models\Patient;

final class DeletePatientAction
{
    public function execute(Patient $patient): bool|null
    {
        return $patient->deleteOrFail();
    }
}
