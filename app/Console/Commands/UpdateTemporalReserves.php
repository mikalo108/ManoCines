<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TemporalReserve;
use Carbon\Carbon;

class UpdateTemporalReserves extends Command
{
    protected $signature = 'temporalreserves:update';

    protected $description = 'Update the reserve_time countdown for temporal reserves';

    public static function handle()
    {
        $now = Carbon::now();

        $temporalReserves = TemporalReserve::all();

        foreach ($temporalReserves as $reserve) {
            $reserveTime = $reserve->reserve_time;
            if ($reserveTime) {
                $reserveTime_d = Carbon::parse($reserveTime);
                $diffInSeconds = $reserveTime_d->diffInSeconds($now, false);
                // If diffInSeconds is negative, time is in the future, so countdown is positive
                $countdown = $diffInSeconds > 0 ? 0 : abs($diffInSeconds);
                if($countdown == 0) {
                    $reserve->delete();
                }
            }
        }
    }
}
