<?php

use App\Models\Setting;
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
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('label');
            $table->text('value')->nullable();
            $table->json('attributes')->nullable();
            $table->string('type');
            $table->timestamps();
        });

        Setting::create([
            'key' => 'check_in_time',
            'label' => 'Check In Time',
            'value' => null,
            'type' => 'time',
        ]);

        Setting::create([
            'key' => 'check_out_time',
            'label' => 'Check Out Time',
            'value' => null,
            'type' => 'time',
        ]);

        Setting::create([
            'key' => 'flexible_time',
            'label' => 'Flexible Time',
            'value' => null,
            'type' => 'number',
        ]);

        Setting::create([
            'key' => 'lunch_start',
            'label' => 'Lunch start',
            'value' => null,
            'type' => 'time',
        ]);

        Setting::create([
            'key' => 'lunch_end',
            'label' => 'Lunch end',
            'value' => null,
            'type' => 'time',
        ]);

        Setting::create([
            'key' => 'working_time',
            'label' => 'Working time',
            'value' => null,
            'type' => 'number',
        ]);

        Setting::create([
            'key' => 'block_time_late',
            'label' => 'Block time late',
            'value' => null,
            'type' => 'number',
        ]);

        Setting::create([
            'key' => 'block_time_early',
            'label' => 'Block time early',
            'value' => null,
            'type' => 'number',
        ]);

        Setting::create([
            'key' => 'ot_night_start',
            'label' => 'OT night time start',
            'value' => null,
            'type' => 'time',
        ]);

        Setting::create([
            'key' => 'ot_night_end',
            'label' => 'OT night time end',
            'value' => null,
            'type' => 'time',
        ]);


        // Setting::create([
        //     'key' => 'environment',
        //     'label' => 'Environment',
        //     'value' => 'production',
        //     'type' => 'select',
        //     'attributes' => [
        //         'options' => [
        //             'production' => 'Production',
        //             'staging' => 'Staging',
        //             'local' => 'Local',
        //         ],
        //     ],
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};