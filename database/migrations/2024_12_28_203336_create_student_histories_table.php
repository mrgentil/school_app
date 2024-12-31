<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('set null');
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('set null');
            $table->string('academic_year');
            $table->enum('semester', ['Semestre 1', 'Semestre 2']);
            $table->decimal('average_score', 5, 2)->nullable();
            $table->integer('rank')->nullable();
            $table->enum('decision', ['En cours', 'Admis', 'Ajourné', 'Redouble'])->default('En cours');
            $table->text('teacher_remarks')->nullable();
            $table->string('conduct_grade')->nullable();
            $table->text('attendance_record')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_histories');
    }
};
