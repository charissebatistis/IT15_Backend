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
        Schema::create('school_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('day_type', ['Regular', 'Holiday', 'Event', 'Exam'])->default('Regular');
            $table->text('description')->nullable();
            $table->integer('attendance_count')->default(0);
            $table->integer('total_students')->default(0);
            $table->timestamps();
            
            // Index for efficient querying
            $table->index('date');
            $table->index('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_days');
    }
};
