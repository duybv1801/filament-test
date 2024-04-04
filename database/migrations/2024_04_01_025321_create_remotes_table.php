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
        Schema::create('remotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('have_plan', ['Have plan', 'Not plan']);
            $table->foreignId('approver_id')->constrained('users');
            $table->text('reason');
            $table->text('remedies');
            $table->text('reject_reason')->nullable();
            $table->enum('status', ['Pending', 'Wait confirm', 'Confirmed', 'Reject', 'Cancel']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remotes');
    }
};
