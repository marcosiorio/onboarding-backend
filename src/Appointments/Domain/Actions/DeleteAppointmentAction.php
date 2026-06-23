<?php

declare(strict_types=1);

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

        if ($now->diffInHours($start) >= $appointment->getAppointmentCancelationTime()) {
            $appointment->deleteOrFail();
        } else {
            $appointment->status = AppointmentStatusEnum::CANCELLED;
            $appointment->saveOrFail();
        }
        return $appointment;
    }
}
