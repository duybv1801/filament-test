<?php

use Carbon\Carbon;

if (! function_exists('isStartTimeBeforeNow')) {
    function isStartTimeBeforeNow($timeRanges): bool {
        $now = Carbon::now();
        foreach ($timeRanges as $timeRange) {
            $startTime = Carbon::parse($timeRange['remotePeriods']['date']);
            if ($startTime < $now) {
                return true;
            }
        }
        return false;
    }
}