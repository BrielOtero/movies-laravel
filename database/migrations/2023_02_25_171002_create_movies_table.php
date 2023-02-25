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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('genre_id')->unsigned();
            $table->integer('user_id')->index();
            $table->string('name');
            $table->integer('duration')->unsigned();
            $table->string('director');
            $table->boolean('box_office');
            $table->timestamps();
            $table->foreign("genre_id")->references('id')->on('genres')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
