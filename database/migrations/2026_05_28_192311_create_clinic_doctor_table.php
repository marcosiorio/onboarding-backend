<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_doctor', function (Blueprint $table) {
            $table->foreignId('doctor_id')->constrained();
            $table->foreignId('clinic_id')->constrained();
            $table->primary(['doctor_id', 'clinic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_doctor');
    }
};
