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
        Schema::create('customer_vehicles', function (Blueprint $table) {
            $table->id('idCustomer_Vehicle');
            $table->string('vehicleNumber');
            $table->string('vehicleBrand');
            $table->string('model');
            $table->string('trim_edition');
            $table->string('modalYear');
            $table->string('descripton');
            $table->string('customer_idCustomer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_vehicles');
    }
};
