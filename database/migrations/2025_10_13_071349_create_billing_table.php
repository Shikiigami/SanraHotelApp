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
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkin_id')->constrained('checkins')->onDelete('cascade');
            $table->string('guest_name');
            $table->integer('room_number');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status',['Paid', 'Partially Paid', 'Pending']);
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing');
    }
};
