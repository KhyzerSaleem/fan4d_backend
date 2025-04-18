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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->double('price')->default(0);
            $table->bigInteger('custom_quantity_from')->default(0);
            $table->bigInteger('custom_quantity_to')->default(0);
            $table->string('image')->nullable();
            $table->tinyInteger('have_discount')->default(0);
            $table->double('discount')->default(0);
            $table->tinyInteger('is_active')->default(1)->comment("1 active , 0 inactive");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
