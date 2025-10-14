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
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('cascade');
            $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->timestamp('actual_check_in_time')->nullable();
            $table->timestamp('actual_check_out_time')->nullable();
            $table->decimal('deposit', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0); 
            $table->text('remarks')->default('');
            $table->enum('status', ['Checked In', 'Checked Out'])->default('Checked In');
            $table->enum('payment_status', ['Pending', 'Paid', 'Partially Paid'])->default('Pending');
            $table->string('payment_method')->default(' ');
            $table->string('payment_reference')->default(' ');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
     }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
