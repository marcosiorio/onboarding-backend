<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Appointments\Domain\Enums\AppointmentStatusEnum;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $startDate = CarbonImmutable::parse(fake()->dateTimeBetween('now', '+1 years'));

        return [
            'clinic_id'  => ClinicFactory::new(),
            'doctor_id'  => DoctorFactory::new(),
            'patient_id' => PatientFactory::new(),
            'start_date' => $startDate,
            'end_date'   => $startDate->addMinutes(30),
            'status'     => AppointmentStatusEnum::ACTIVE->value,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Appointment $appointment): void {
            Doctor::query()->find($appointment->doctor_id)?->clinics()->syncWithoutDetaching([$appointment->clinic_id]);
        });
    }

    public function startingInHours(int $hours): static
    {
        $startDate = CarbonImmutable::now()->addHours($hours);

        return $this->state([
            'start_date' => $startDate,
            'end_date'   => $startDate->addMinutes(30),
        ]);
    }
}
