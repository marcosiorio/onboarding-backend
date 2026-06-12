<?php

declare(strict_types=1);

namespace Lightit\Patients\Domain\Actions;

use Lightit\Patients\Domain\Models\Patient;

final readonly class UpsertPatientAction
{
    public function execute(string $name, string $email, string $password, Patient|null $patient = null): Patient
    {
        $newPatient = $patient ?? new Patient();

        $newPatient->name = $name;
        $newPatient->email = $email;
        $newPatient->password = $password;

        $newPatient->saveOrFail();

        return $newPatient;
    }
}
