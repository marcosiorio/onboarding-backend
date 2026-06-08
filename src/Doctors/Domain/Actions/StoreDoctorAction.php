<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\DataTransferObjects\DoctorDto;
use Lightit\Doctors\Domain\Models\Doctor;

class StoreDoctorAction
{
    /**
     * @mixin Doctor
     */
    public function execute(DoctorDto $doctorDto): Doctor
    {
        $doctor = new Doctor();
        $doctor->name = $doctorDto->name;

        $doctor->saveOrFail();

        return $doctor;
    }
}
