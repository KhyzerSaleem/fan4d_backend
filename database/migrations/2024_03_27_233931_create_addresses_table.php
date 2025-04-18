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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\City::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\Area::class)->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('address');
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->tinyInteger('is_default')->default(0)->comment("only one row for each user can be default");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
