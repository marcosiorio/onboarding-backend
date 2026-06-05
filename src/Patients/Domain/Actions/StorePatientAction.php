<?php

declare(strict_types=1);

namespace Lightit\Patients\Domain\Actions;

use Lightit\Patients\Domain\Models\Patient;

class StorePatientAction
{
    public function execute(string $name, string $email): Patient
    {
        $patient = new Patient();
        $patient->name = $name;
        $patient->email = $email;

        $patient->saveOrFail();

        return $patient;
    }
}
