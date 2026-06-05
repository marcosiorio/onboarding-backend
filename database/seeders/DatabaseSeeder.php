<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->createMany(35);
        PatientFactory::new()->createMany(20);

        $clinics = ClinicFactory::new()->createMany(10);
        $doctors = DoctorFactory::new()->createMany(15);

        $clinics->each(function ($clinic) use ($doctors) {
            $clinic->doctors()->attach(
                $doctors->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
