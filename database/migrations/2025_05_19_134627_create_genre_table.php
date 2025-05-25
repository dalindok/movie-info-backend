<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('genre', function (Blueprint $table) {
            $table->id();             // Auto-increment primary key "id"
            $table->string('name');   // Name column
            $table->timestamps();     // created_at and updated_at
        });
    }

    public function down(): void
    {
        
    }
};