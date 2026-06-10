<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Patients\Domain\Models\Patient;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->createMany(35);
        $doctors = DoctorFactory::new()->createMany(35);
        ClinicFactory::new()
            ->hasAttached($doctors->random(rand(1, 3)))
            ->createMany(35);
        PatientFactory::new()->createMany(35);

        $patients = Patient::all();
        $clinics = Clinic::with('doctors')->get();
        $statuses = ['active', 'cancelled'];

        foreach ($clinics as $clinic) {
            foreach ($clinic->doctors as $doctor) {
                $appointmentCount = rand(1, 3);
                for ($i = 0; $i < $appointmentCount; $i++) {
                    $startDate = now()->addDays(rand(1, 60))->setTime(rand(8, 16), 0);
                    Appointment::create([
                        'doctor_id'  => $doctor->id,
                        'patient_id' => $patients->random()->id,
                        'clinic_id'  => $clinic->id,
                        'start_date' => $startDate,
                        'end_date'   => $startDate->copy()->addMinutes(30),
                        'status'     => $statuses[array_rand($statuses)],
                    ]);
                }
            }
        }
    }
}
