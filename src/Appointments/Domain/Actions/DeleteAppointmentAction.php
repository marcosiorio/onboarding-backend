<?php

namespace Lightit\Appointments\Domain\Actions;

use Carbon\CarbonImmutable;
use Lightit\Appointments\Domain\Enums\AppointmentStatusEnum;
use Lightit\Appointments\Domain\Models\Appointment;

final readonly class DeleteAppointmentAction
{
    public function execute(Appointment $appointment): Appointment
    {
        $now = CarbonImmutable::now();
        $start = CarbonImmutable::parse($appointment->start_date);

        if($now->diffInHours($start) >= 48){
            $appointment->deleteOrFail();
        }else{
            $appointment->status = AppointmentStatusEnum::CANCELLED->value;
        }
        return $appointment;
    }
}
