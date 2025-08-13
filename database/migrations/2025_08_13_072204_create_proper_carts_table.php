<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing problematic tables
        Schema::dropIfExists('cart');
        Schema::dropIfExists('carts');
        
        // Create proper carts table
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('part_id')->constrained('parts', 'idPart')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('totalprice', 10, 2);
            $table->timestamps();
            
            $table->unique(['user_id', 'part_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};