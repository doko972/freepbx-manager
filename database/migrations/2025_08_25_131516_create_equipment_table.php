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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phone_number_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // 'Téléphone fixe', 'Application mobile', etc.
            $table->string('extension')->nullable();
            $table->string('user_name')->nullable();
            $table->string('mac_address')->nullable();
            $table->json('configuration')->nullable(); // JSON pour config avancée
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Index pour performance
            $table->index(['phone_number_id', 'is_active']);
            $table->index('extension');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};