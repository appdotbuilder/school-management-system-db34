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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date')->comment('Date of attendance record');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->comment('Attendance status');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            $table->unique(['student_id', 'course_id', 'attendance_date']);
            $table->index(['student_id', 'attendance_date']);
            $table->index(['course_id', 'attendance_date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};