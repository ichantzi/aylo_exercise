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
        Schema::create('pornstars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('license')->nullable();
            $table->tinyInteger('wlStatus')->nullable();
            $table->string('hairColor')->nullable();
            $table->string('ethnicity')->nullable();
            $table->boolean('tattoos')->nullable();
            $table->boolean('piercings')->nullable();
            $table->integer('breastSize')->nullable();
            $table->char('breastType', 1)->nullable();
            $table->string('gender');
            $table->string('orientation')->nullable();
            $table->integer('age')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pornstars');
    }
};
