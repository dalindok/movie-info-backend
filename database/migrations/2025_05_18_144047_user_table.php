<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');              // Custom primary key
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();               // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
