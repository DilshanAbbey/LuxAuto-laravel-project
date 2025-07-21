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
        Schema::create('customer_chats', function (Blueprint $table) {
            $table->id('idCustomer_Chat');
            $table->string('date');
            $table->string('description');
            $table->string('technician');
            $table->string('status');
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
        Schema::dropIfExists('customer_chats');
    }
};
