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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('assignment_type')->comment('Type: quiz, test, assignment, project, etc.');
            $table->string('assignment_name')->comment('Name of the assignment');
            $table->decimal('points_earned', 5, 2)->comment('Points earned by student');
            $table->decimal('points_possible', 5, 2)->comment('Total points possible');
            $table->decimal('percentage', 5, 2)->comment('Calculated percentage');
            $table->string('letter_grade', 2)->nullable()->comment('Letter grade: A, B, C, D, F');
            $table->date('assignment_date')->comment('Date assignment was given');
            $table->text('comments')->nullable()->comment('Teacher comments');
            $table->timestamps();
            
            $table->index(['student_id', 'course_id']);
            $table->index('assignment_date');
            $table->index('assignment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};