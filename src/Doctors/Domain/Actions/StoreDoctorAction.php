<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\Models\Doctor;

class StoreDoctorAction
{
    public function execute(string $name): Doctor
    {
        $doctor = new Doctor();
        $doctor->name = $name;

        $doctor->saveOrFail();

        return $doctor;
    }
}
