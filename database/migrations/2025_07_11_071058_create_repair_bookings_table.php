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
        Schema::create('repair_bookings', function (Blueprint $table) {
            $table->id('idRepair_booking');
            $table->string('slotNumber');
            $table->string('date');
            $table->string('time');
            $table->string('technician');
            $table->string('vehicle_id');
            $table->string('customer_id');
            $table->string('employee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_bookings');
    }
};
