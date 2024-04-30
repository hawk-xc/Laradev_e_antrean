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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable(true);
            $table->integer('role_id')->nullable(false)->default(4);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable(true);
            $table->string('user_image')->default('images/guest.png')->nullable(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(true);
            $table->string('google_id')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
