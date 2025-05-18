<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->text('symptoms');
            $table->text('diagnosis');
            $table->text('notes')->nullable();
            $table->json('vitals')->nullable(); // Blood pressure, temperature, etc.
            $table->timestamps();
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_id')->constrained()->onDelete('cascade');
            $table->json('medications'); // Array of medications with dosage
            $table->text('instructions');
            $table->date('valid_until');
            $table->boolean('is_dispensed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('diagnoses');
    }
}; 