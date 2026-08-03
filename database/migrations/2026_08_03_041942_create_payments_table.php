<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->nullable(); // Boleh null jika kita hanya pakai student_id & package_id untuk perpanjangan langsung
            $table->foreignId('student_id')->nullable();
            $table->foreignId('package_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_type')->default('qris');
            $table->string('payment_method')->default('qris_manual');
            $table->string('qris_token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('proof_image')->nullable();
            $table->enum('status', ['pending', 'success', 'rejected'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->date('payment_period')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
