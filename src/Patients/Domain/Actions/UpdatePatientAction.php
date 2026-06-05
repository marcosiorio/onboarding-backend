<?php

declare(strict_types=1);

namespace Lightit\Patients\Domain\Actions;

use Lightit\Patients\Domain\Models\Patient;

final readonly class UpdatePatientAction
{
    public function execute(Patient $patient, ?string $name, ?string $email): Patient
    {
        if ($name !== null) {
            $patient->name = $name;
        }

        if ($email !== null) {
            $patient->email = $email;
        }

        $patient->save();

        return $patient;
    }
}
