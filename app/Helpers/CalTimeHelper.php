<?php
use App\Models\Setting;
use Carbon\Carbon;

if (! function_exists('calculator_working_hours')) {
    /**
     * function calculator working hours
     */
    function calculator_working_hours($check_in, $check_out)
    {
        $in = Carbon::parse($check_in);
        $out = Carbon::parse($check_out);
        if($in->gte($out)) {
            return 0;
        }
        $setting = Setting::all()->pluck('value', 'key')->toArray();
        $startWorkingDay = Carbon::parse($setting['check_in_time']);
        $endWorkingDay = Carbon::parse($setting['check_out_time']);
        $lunStart = Carbon::parse($setting['lunch_start']);
        $lunchEnd = Carbon::parse($setting['lunch_end']);
        //cal time morning
        $checkIn = max($in, $startWorkingDay);

        $endMorningWorking = max($checkIn,min($out, $lunStart));
        $minuteMorning = $checkIn->diffInMinutes($endMorningWorking);

        $startAfternoon = max($in, $lunchEnd);
        $endAfternoon = max($startAfternoon, min($out, $endWorkingDay));
        $minuteAfternoon = $startAfternoon->diffInMinutes($endAfternoon);

        
        $totalMinute =  $minuteMorning + $minuteAfternoon;
        $maxTimeWorkingDay = (int) $setting['working_time'] * 60;
        $recordTime = min($totalMinute, $maxTimeWorkingDay);
        $block =max(1, (int) $setting['block_time_late']);
        $minutes = floor($recordTime/$block)*$block;

        return $minutes/60;
    }
}
