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
        Schema::create('played_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->nullable()->constrained('players');
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes');
            $table->foreignId('expo_id')->nullable()->constrained('expos');
            $table->timestamp('started_on')->useCurrent();
            $table->timestamp('ended_on')->nullable();
            $table->integer('points')->nullable();
            $table->integer('quiz_max_points')->nullable();
            $table->string('quiz_name', 100)->nullable();
            $table->string('expo_name', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('played_quizzes');
    }
};
