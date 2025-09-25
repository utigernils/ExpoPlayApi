<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consoles', function (Blueprint $table) {
            $table->id();
            $table->char('api_token', 36)->default(new Expression('(UUID())'));
            $table->foreignId('current_expo_id')->nullable()->constrained('expos');
            $table->foreignId('current_quiz_id')->nullable()->constrained('quizzes');
            $table->string('name', 100);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consoles');
    }
};
