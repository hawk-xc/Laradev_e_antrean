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
        Schema::table('devices', function (Blueprint $table) {
            $table->string('image_link')->nullable(true)->default('-');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->string('image_link')->nullable(true)->default('-');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('image_link');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('image_link');
        });
    }
};
