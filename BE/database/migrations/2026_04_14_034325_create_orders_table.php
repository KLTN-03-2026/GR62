<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_goi')->nullable();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('amount');
            $table->string('status')->default('pending'); // pending|paid|failed
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();

            $table->string('sepay_transaction_id')->nullable()->unique();
            $table->string('sepay_reference_number')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('payment_meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
