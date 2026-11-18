<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // Professional Identity
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('professional_title');
            $table->string('tagline')->nullable();
            $table->string('location')->nullable();

            // Description
            $table->text('short_bio')->nullable();
            $table->longText('about')->nullable();

            // Contact Information
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();

            // Social Media
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();

            // Availability
            $table->boolean('availability_status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
