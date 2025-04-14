<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama pemesan
            $table->string('menu');
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->integer('price');
            $table->dateTime('order_date'); // ubah dari date ke dateTime
            $table->timestamps();
            $table->string('payment_method')->default('Cash'); // QRIS, Cash, Transfer
            $table->boolean('add_egg')->default(false); // Yes or No
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};

