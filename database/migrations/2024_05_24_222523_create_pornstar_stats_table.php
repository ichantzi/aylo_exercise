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
        Schema::create('pornstar_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pornstar_id')->constrained('pornstars')->onDelete('cascade');
            $table->integer('subscriptions')->nullable();
            $table->integer('monthlySearches')->nullable();
            $table->integer('views')->nullable();
            $table->integer('videosCount')->nullable();
            $table->integer('premiumVideosCount')->nullable();
            $table->integer('whiteLabelVideoCount')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('rankPremium')->nullable();
            $table->integer('rankWl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pornstar_stats');
    }
};
