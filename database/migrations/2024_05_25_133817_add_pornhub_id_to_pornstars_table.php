<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pornstars', function (Blueprint $table) {
            $table->unsignedBigInteger('pornhub_id')->unique()->after('id');
        });
    }

    public function down()
    {
        Schema::table('pornstars', function (Blueprint $table) {
            $table->dropColumn('pornhub_id');
        });
    }
};
