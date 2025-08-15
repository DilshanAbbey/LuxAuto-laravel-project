<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the existing problematic table
        Schema::dropIfExists('customer_vehicles');
        
        // Recreate with proper structure
        Schema::create('customer_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('idCustomer_Vehicle')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('vehicleNumber');
            $table->string('vehicleBrand');
            $table->string('model');
            $table->string('trim_edition');
            $table->string('modalYear');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_vehicles');
    }
};
