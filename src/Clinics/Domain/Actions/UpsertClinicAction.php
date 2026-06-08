<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Actions;

use Lightit\Clinics\Domain\Models\Clinic;

final readonly class UpsertClinicAction
{
    public function execute(string $name, string $address, Clinic|null $clinic = null): Clinic
    {
        $newClinic = $clinic ?? new Clinic();

        $newClinic->name = $name;
        $newClinic->address = $address;

        $newClinic->saveOrFail();

        return $newClinic;
    }
}
