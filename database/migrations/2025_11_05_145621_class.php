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
        Schema::create('class', function(Blueprint $table)
        {
            $table->id('name');
            $table->string('name');
            $table->foreignId('teacher_id');
            $table->time('start_time');
            $table->time('end_time');

            // amount of students can be calculated
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('class');
    }
};
