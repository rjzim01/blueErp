<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('damages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barcode_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name', 255)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->date('damage_date')->nullable();
            $table->text('damage_reason')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('entry_by')->nullable();
            $table->timestamps();
            
            $table->index('barcode_id');
            $table->index('product_id');
            $table->index('barcode');
            $table->index('damage_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damages');
    }
};