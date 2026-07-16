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
        Schema::create('coin_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_money')->default(0);
            $table->string('status');
            $table->enum('coin_side', ['number', 'face'])->default('number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_tables');
    }
};
