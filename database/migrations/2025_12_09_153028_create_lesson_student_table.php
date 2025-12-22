<?php
};
    }
        Schema::dropIfExists('lesson_student');
    {
    public function down(): void
     */
     * Reverse the migrations.
    /**

    }
        });
            $table->unique(['lesson_id', 'student_id']);

            $table->timestamps();
            $table->integer('score')->nullable();
            $table->boolean('attendance')->default(false);
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->id();
        Schema::create('lesson_student', function (Blueprint $table) {
    {
    public function up(): void
     */
     * Run the migrations.
    /**
{
return new class extends Migration

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


