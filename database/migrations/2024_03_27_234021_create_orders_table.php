<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('address_id')->references('id')->on('addresses')->onDelete('restrict');
            $table->double('sub_total')->default(0);
            $table->double('discount')->default(0);
            $table->double('tax')->default(0);
            $table->double('total')->default(0);
            $table->text('notes')->nullable();

            $table->enum('status', ['pending', 'in_progress','in_way', 'complete', 'cancelled'])->default('pending');
            $table->enum('payment_status', [ 'paid', 'unpaid'])->default('unpaid');
            $table->enum('payment_method', ['credit', 'cash','wallet', 'apple', 'mada'])->default('cash');

            $table->string('voucher_code')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
