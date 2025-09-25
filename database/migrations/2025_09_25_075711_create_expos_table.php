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
        Schema::create('expos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('introduction_title');
            $table->text('introduction_subtitle')->nullable();
            $table->string('location', 150)->nullable();
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expos');
    }
};
