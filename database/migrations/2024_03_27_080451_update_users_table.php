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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->default(3);
            $table->tinyInteger('gender')->default(1);
            $table->date('start_date')->nullable()->useCurrent();
            $table->string('phone', 10)->nullable();
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
