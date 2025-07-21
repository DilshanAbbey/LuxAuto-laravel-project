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
        Schema::create('parts', function (Blueprint $table) {
            $table->id('idPart');
            $table->string('partName');
            $table->string('partNumber');
            $table->string('brand');
            $table->string('model');
            $table->float('price');
            $table->string('description');
            $table->integer('quantityInStock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
