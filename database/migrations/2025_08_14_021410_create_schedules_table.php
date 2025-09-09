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
        Schema::create('schedules', function (Blueprint $table) {
            $t->id();
            $t->date('date');
            $t->time('start_time');
            $t->time('end_time');

            $t->foreignId('group_id')->nullable()->constrained();
            $t->foreignId('teacher_id')->nullable()->constrained('users');
            $t->foreignId('room_id')->nullable()->constrained();

            $t->string('title');        // название пары / предмет
            $t->string('description')->nullable(); // опционально: тема занятия
            $t->timestamps();

            $t->index(['date']);
            $t->index(['teacher_id', 'date']);
            $t->index(['group_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
