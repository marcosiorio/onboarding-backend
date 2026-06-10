<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Enums\AppointmentStatusEnum;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;

final readonly class UpsertAppointmentAction
{
    public function execute(AppointmentDto $appointmentDto): Appointment
    {
        $appointment = new Appointment();
        $doctorsWithClinics = Doctor::query()->with('clinics')
            ->find($appointmentDto->doctor_id);

        if( !$doctorsWithClinics->clinics->contains('id', $appointmentDto->clinic_id) ) {
            throw new Exception('Selected doctor doesn\'t work at the selected clinic');
        }

        $start = CarbonImmutable::parse($appointmentDto->start_date);
        $end = $start->addMinutes($appointment->getDurationInMinutes());

        $conflictDoctor = Appointment::query()->where('doctor_id', $appointmentDto->doctor_id)
            ->where(function (Builder $query) use ($start, $end): void {
                $query
                    ->where('start_date', '<', $end)
                    ->where('end_date', '>', $start)
                    ->whereNot('status', AppointmentStatusEnum::CANCELLED);
            })->exists();

        if ($conflictDoctor) {
            throw new Exception('Doctor is not available in this time, choose another one');
        }

        $conflictPatient = Appointment::query()->where('patient_id', $appointmentDto->patient_id)
            ->where(function (\Illuminate\Contracts\Database\Query\Builder $query) use ($start, $end): void {
                $query
                    ->where('start_date', '<', $end)
                    ->where('end_date', '>', $start)
                    ->whereNot('status', AppointmentStatusEnum::CANCELLED);
            })->exists();

        if ($conflictPatient) {
            throw new Exception('You have an overlapping appointment in this time, choose another one.');
        }

        $appointment->doctor_id = $appointmentDto->doctor_id;
        $appointment->patient_id = $appointmentDto->patient_id;
        $appointment->clinic_id = $appointmentDto->clinic_id;
        $appointment->start_date = $appointmentDto->start_date;
        $appointment->end_date = $end;
        $appointment->status = AppointmentStatusEnum::ACTIVE;

        $appointment->saveOrFail();

        return $appointment;
    }
}
