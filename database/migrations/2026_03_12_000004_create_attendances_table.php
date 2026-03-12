<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_day_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Present', 'Absent', 'Late', 'Excused'])->default('Absent');
            $table->timestamps();
            
            // Ensure unique attendance record per student per day
            $table->unique(['student_id', 'school_day_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
