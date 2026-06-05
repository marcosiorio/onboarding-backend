<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Actions;

use Lightit\Clinics\Domain\Models\Clinic;

class StoreClinicAction
{
    public function execute(string $name, string $address): Clinic
    {
        $clinic = new Clinic();
        $clinic->name = $name;
        $clinic->address = $address;

        $clinic->saveOrFail();

        return $clinic;
    }
}
