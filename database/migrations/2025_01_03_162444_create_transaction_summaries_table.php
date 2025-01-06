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
        Schema::create('transaction_summaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_stock_id');
            $table->float('sum')->default('0'); 
            $table->enum('type', ['sell','buy']); 
            $table->string('lot_no', 50)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_summaries');
    }
};
