<?php

declare(strict_types=1);

namespace Lightit\Patients\Domain\Actions;

use Lightit\Patients\Domain\Models\Patient;

final readonly class UpdatePatientAction
{
    public function execute(Patient $patient, string $name, string $email): Patient
    {
        $patient->name = $name;
        $patient->email = $email;

        $patient->saveOrFail();

        return $patient;
    }
}
