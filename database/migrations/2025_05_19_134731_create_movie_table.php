<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie', function (Blueprint $table) {
            $table->id();
            $table->string('movie_title');
            $table->text('movie_description');
            
            // Foreign keys
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('rate_id');
            // $table->unsignedBigInteger('cast_id');
  $table->string('actor1'); // main actor
        $table->string('actor2')->nullable(); // supporting actor
            // Media fields
            $table->string('movie_poster')->nullable(); // URL or path to poster image
            $table->date('released_date');
            $table->string('movie_trailer')->nullable(); // URL to trailer

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('ratings')->onDelete('cascade');
          
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};