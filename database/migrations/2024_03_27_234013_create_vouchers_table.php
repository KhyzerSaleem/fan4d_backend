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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->enum('type',['general','points_reward'])->default('general');
            $table->string('title_ar');
            $table->string('title_en');
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();
            $table->string('image')->nullable();
            $table->string('code')->unique();
            $table->date('start_date');
            $table->date('expire_date');
            $table->double('min_order_price')->default(0);
            $table->integer('user_use_count')->default(1)->comment('عدد مرات الاستخدام للمستخدم الواحد');
            $table->tinyInteger('is_active')->default(1);
            $table->integer('use_count')->comment('عدد مرات الاستخدام');
            $table->integer('voucher_used_count')->default(0)->comment('عدد مرات استخدامات الكوبون');
            $table->tinyInteger('for_first_order')->default(0);
            $table->double('percent')->default(0);
            $table->double('amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
