<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('idEmployee')->unique();
            $table->string('employeeName');
            $table->string('nic')->unique();
            $table->string('email')->unique();
            $table->string('contactNumber');
            $table->enum('role', ['administrator', 'employee', 'technician']);
            $table->decimal('salary', 10, 2);
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
