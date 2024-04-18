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
        Schema::create('proces', function (Blueprint $table) {
            $table->id();
            $table->integer('status_id')->nullable(false);
            $table->integer('ticket_id')->nullable(false);
            $table->integer('user_id')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proces');
    }
};
