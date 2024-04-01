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
        Schema::create('remote_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remote_id')->constrained('remotes')->cascadeOnDelete();
            $table->date('date');
            $table->time('start', precision: 0);
            $table->time('end', precision: 0);
            $table->decimal('total', 3, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_periods');
    }
};
