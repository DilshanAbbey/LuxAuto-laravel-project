<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix customer_vehicles table
        Schema::table('customer_vehicles', function (Blueprint $table) {
            // Drop the old column with typo
            if (Schema::hasColumn('customer_vehicles', 'descripton')) {
                $table->dropColumn('descripton');
            }
            if (Schema::hasColumn('customer_vehicles', 'customer_idCustomer')) {
                $table->dropColumn('customer_idCustomer');
            }
            
            // Add correct columns if they don't exist
            if (!Schema::hasColumn('customer_vehicles', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('customer_vehicles', 'customer_id')) {
                $table->unsignedBigInteger('customer_id');
                $table->foreign('customer_id')->references('idCustomer')->on('customers')->onDelete('cascade');
            }

            if (!Schema::hasColumn('customer_vehicles', 'idCustomer_Vehicle')) {
                $table->string('idCustomer_Vehicle')->unique()->after('id');
            }
        });

        // Fix customer_deliveries table
        Schema::table('customer_deliveries', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_deliveries', 'id')) {
                $table->id()->first();
            }
            if (!Schema::hasColumn('customer_deliveries', 'customer_id')) {
                $table->unsignedBigInteger('customer_id');
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            }
        });

        // Fix repair_bookings table
        Schema::table('repair_bookings', function (Blueprint $table) {
            // Change string columns to proper types
            if (Schema::hasColumn('repair_bookings', 'date') && 
                Schema::getColumnType('repair_bookings', 'date') === 'string') {
                $table->date('date')->change();
            }
            if (!Schema::hasColumn('repair_bookings', 'time')) {
                $table->time('time')->after('date');
            }
            if (!Schema::hasColumn('repair_bookings', 'technician_in_charge')) {
                $table->string('technician_in_charge')->after('technician');
            }
            
            // Fix foreign key columns
            if (Schema::hasColumn('repair_bookings', 'vehicle_id') && 
                Schema::getColumnType('repair_bookings', 'vehicle_id') === 'string') {
                $table->unsignedBigInteger('vehicle_id')->change();
            }
            if (Schema::hasColumn('repair_bookings', 'customer_id') && 
                Schema::getColumnType('repair_bookings', 'customer_id') === 'string') {
                $table->unsignedBigInteger('customer_id')->change();
            }
        });

        // Fix service_bookings table
        Schema::table('service_bookings', function (Blueprint $table) {
            // Change string columns to proper types
            if (Schema::hasColumn('service_bookings', 'date') && 
                Schema::getColumnType('service_bookings', 'date') === 'string') {
                $table->date('date')->change();
            }
            if (!Schema::hasColumn('service_bookings', 'time')) {
                $table->time('time')->after('date');
            }
            
            // Fix foreign key columns
            if (Schema::hasColumn('service_bookings', 'vehicle_id') && 
                Schema::getColumnType('service_bookings', 'vehicle_id') === 'string') {
                $table->unsignedBigInteger('vehicle_id')->change();
            }
            if (Schema::hasColumn('service_bookings', 'customer_id') && 
                Schema::getColumnType('service_bookings', 'customer_id') === 'string') {
                $table->unsignedBigInteger('customer_id')->change();
            }
        });

        // Fix vehicle_repairs table
        Schema::table('vehicle_repairs', function (Blueprint $table) {
            // Change date column type
            if (Schema::hasColumn('vehicle_repairs', 'repairDate') && 
                Schema::getColumnType('vehicle_repairs', 'repairDate') === 'string') {
                $table->date('repairDate')->change();
            }
            
            // Fix foreign key columns
            if (Schema::hasColumn('vehicle_repairs', 'vehicle_id') && 
                Schema::getColumnType('vehicle_repairs', 'vehicle_id') === 'string') {
                $table->unsignedBigInteger('vehicle_id')->change();
            }
            if (Schema::hasColumn('vehicle_repairs', 'customer_id') && 
                Schema::getColumnType('vehicle_repairs', 'customer_id') === 'string') {
                $table->unsignedBigInteger('customer_id')->change();
            }
        });

        // Fix vehicle_services table
        Schema::table('vehicle_services', function (Blueprint $table) {
            // Change date column type
            if (Schema::hasColumn('vehicle_services', 'serviceDate') && 
                Schema::getColumnType('vehicle_services', 'serviceDate') === 'string') {
                $table->date('serviceDate')->change();
            }
            
            // Fix foreign key columns
            if (Schema::hasColumn('vehicle_services', 'vehicle_id') && 
                Schema::getColumnType('vehicle_services', 'vehicle_id') === 'string') {
                $table->unsignedBigInteger('vehicle_id')->change();
            }
            if (Schema::hasColumn('vehicle_services', 'customer_id') && 
                Schema::getColumnType('vehicle_services', 'customer_id') === 'string') {
                $table->unsignedBigInteger('customer_id')->change();
            }
        });

        // Fix customer_chats table
        Schema::table('customer_chats', function (Blueprint $table) {
            // Change date column type
            if (Schema::hasColumn('customer_chats', 'date') && 
                Schema::getColumnType('customer_chats', 'date') === 'string') {
                $table->date('date')->change();
            }
            
            // Fix foreign key columns
            if (Schema::hasColumn('customer_chats', 'customer_id') && 
                Schema::getColumnType('customer_chats', 'customer_id') === 'string') {
                $table->unsignedBigInteger('customer_id')->change();
            }
            if (Schema::hasColumn('customer_chats', 'employee_id') && 
                Schema::getColumnType('customer_chats', 'employee_id') === 'string') {
                $table->unsignedBigInteger('employee_id')->change();
            }
        });
    }

    public function down(): void
    {
        // Reverse the changes if needed
    }
};
