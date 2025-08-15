<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_chats', function (Blueprint $table) {
            // Drop the primary key constraint on idCustomer_Chat
            if (Schema::hasColumn('customer_chats', 'idCustomer_Chat')) {
                $table->dropColumn('idCustomer_Chat');
            }
            
            // Add a proper id column as primary key
            if (!Schema::hasColumn('customer_chats', 'id')) {
                $table->id()->first();
            }
            else{
                Schema::create('customer_chats', function (Blueprint $table) {
                $table->id();
                });
            }
            
            // Fix column types
            $table->date('date')->change();
            $table->text('description')->change();
            $table->unsignedBigInteger('customer_id')->change();
            $table->unsignedBigInteger('employee_id')->nullable()->change();
            
            // Add foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down(): void
    {
        //
    }
};
