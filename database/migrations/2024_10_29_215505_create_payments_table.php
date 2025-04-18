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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('user_plan_id')->references('id')->on('user_plans')->onDelete('restrict');
            $table->string('invoice_id');
            $table->text('invoice_url');
            $table->double('price')->default(0);
            $table->tinyInteger('is_completed')->default(0);
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
