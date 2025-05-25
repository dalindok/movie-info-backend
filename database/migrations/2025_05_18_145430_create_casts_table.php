<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->id();            // Primary key "id"
            $table->string('name'); // Name of the cast
            $table->timestamps();   // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casts');
    }
};
