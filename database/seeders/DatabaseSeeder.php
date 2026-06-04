<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lightit\Doctors\Domain\Models\Doctor;

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
    }
}
