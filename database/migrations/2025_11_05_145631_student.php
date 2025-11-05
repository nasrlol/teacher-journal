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
        Schema::create('student', function (Blueprint $table) {

            $table->id;
            $table->string('name');
            $table->string('last_name');
            $table->foreignId(['group_id']);
            $table->foreignId(['class_id']);
            $table->integer('points');
            $table->timestamp();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::drop('student');
    }
};
