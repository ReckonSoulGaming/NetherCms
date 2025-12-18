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
        Schema::create('payment_method', function (Blueprint $table) {
            $table->bigIncrements('method_id');
            $table->string('method_title');
            $table->string('method_provider');
            $table->timestamps();
            $table->string('razorpay_key')->nullable();
            $table->string('razorpay_secret')->nullable();
            $table->string('stripe_publishable_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('paypal_client_id')->nullable();
            $table->string('paypal_secret_key')->nullable();
            $table->enum('paypal_mode', ['sandbox', 'live'])->default('sandbox');
            $table->string('callback_url')->nullable();
            $table->string('webhook_secret')->nullable();
            $table->boolean('enabled')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method');
    }
};
