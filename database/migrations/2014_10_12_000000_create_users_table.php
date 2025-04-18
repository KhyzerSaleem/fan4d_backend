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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('country_code')->default("966");
            $table->string('phone')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('fcm_token')->nullable();
            $table->enum('platform',['android','ios'])->default("ios");
            $table->bigInteger('login_code')->nullable();
            $table->bigInteger('points')->default(0);
            $table->enum('gender',['male','female'])->default('male');
            $table->date('date_of_birth')->nullable();
            $table->string('value_added_certificate')->nullable();
            $table->string('value_added_certificate_file')->nullable();
            $table->string('company_name')->nullable();
            $table->string('job_name')->nullable();
            $table->string('refer_code')->nullable();
            $table->foreignIdFor(\App\Models\City::class)->constrained()->restrictOnDelete();
            $table->tinyInteger('manual_deleted')->default(0);
            $table->tinyInteger('is_active')->default(1)->comment("1 active , 0 inactive");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
