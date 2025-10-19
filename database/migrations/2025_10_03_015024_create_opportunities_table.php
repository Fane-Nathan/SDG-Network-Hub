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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->string('opportunity_type');
            $table->string('mode')->default('onsite');
            $table->string('sdg_focus')->nullable();
            $table->string('location_country')->nullable();
            $table->string('location_city')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('deadline')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->string('status', 20)->default('open');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->longText('description');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'opportunity_type']);
            $table->index(['location_country', 'location_city']);
            $table->index('sdg_focus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};