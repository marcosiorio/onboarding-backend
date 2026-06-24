<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Lightit\Appointments\App\Notifications\AppointmentNotification;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Enums\AppointmentStatusEnum;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Shared\App\Exceptions\Http\DoctorNotWorkInTheClinicException;
use Lightit\Shared\App\Exceptions\Http\OverlappingAppointmentTimesException;
use OverlappingAppointmentTimesExpection;

final readonly class UpsertAppointmentAction
{
    public function execute(AppointmentDto $appointmentDto, Appointment|null $existing = null): Appointment
    {
        $appointment = $existing ?? new Appointment();

        $patientId = $appointmentDto->patient_id ?? $appointment->patient_id;
        $clinicId = $appointmentDto->clinic_id ?? $appointment->clinic_id;

        $this->ensureDoctorWorksAtClinic($appointmentDto->doctor_id, $clinicId);

        $start = CarbonImmutable::parse($appointmentDto->start_date);
        $end = $this->computeEndDate($start, $appointment);

        $this->ensureNoDoctorConflict($appointmentDto->doctor_id, $start, $end, $existing);
        $this->ensureNoPatientConflict($patientId, $start, $end, $existing);

        $appointment->doctor_id = $appointmentDto->doctor_id;
        $appointment->patient_id = $patientId;
        $appointment->clinic_id = $clinicId;
        $appointment->start_date = $appointmentDto->start_date;
        $appointment->end_date = $end->toDateTimeString();
        $appointment->status = AppointmentStatusEnum::ACTIVE;

        $appointment->saveOrFail();

        $appointment->load(['doctor', 'patient', 'clinic']);

        $appointment->patient->notify(new AppointmentNotification($appointment));

        return $appointment;
    }

    private function ensureDoctorWorksAtClinic(int $doctorId, int|null $clinicId): void
    {
        $doctor = Doctor::query()->with('clinics')->find($doctorId);

        if ($doctor === null || $doctor->clinics->doesntContain('id', $clinicId)) {
            throw new DoctorNotWorkInTheClinicException('Selected doctor doesn\'t work at the selected clinic');
        }
    }

    private function computeEndDate(CarbonImmutable $start, Appointment $appointment): CarbonImmutable
    {
        return $start->addMinutes($appointment->durationInMinutes);
    }

    private function ensureNoDoctorConflict(
        int $doctorId,
        CarbonImmutable $start,
        CarbonImmutable $end,
        Appointment|null $existing,
    ): void {
        $query = Appointment::query()->where('doctor_id', $doctorId);

        if ($existing instanceof Appointment) {
            $query->where('id', '!=', $existing->id);
        }

        $conflict = $query->where(function (Builder $query) use ($start, $end): void {
            $query
                ->where('start_date', '<', $end)
                ->where('end_date', '>', $start)
                ->whereNot('status', AppointmentStatusEnum::CANCELLED);
        })->exists();

        if ($conflict) {
            throw new OverlappingAppointmentTimesException('Doctor is not available in this time, choose another one');
        }
    }

    private function ensureNoPatientConflict(
        int|null $patientId,
        CarbonImmutable $start,
        CarbonImmutable $end,
        Appointment|null $existing,
    ): void {
        $query = Appointment::query()->where('patient_id', $patientId);

        if ($existing instanceof Appointment) {
            $query->where('id', '!=', $existing->id);
        }

        $conflict = $query->where(function (Builder $query) use ($start, $end): void {
            $query
                ->where('start_date', '<', $end)
                ->where('end_date', '>', $start)
                ->whereNot('status', AppointmentStatusEnum::CANCELLED);
        })->exists();

        if ($conflict) {
            throw new OverlappingAppointmentTimesException('You have an overlapping appointment in this time, choose another one.');
        }
    }
}
