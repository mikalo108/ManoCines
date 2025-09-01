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

                // 10 minutes countdown
                $countdown =  60*10;

                // If diffInSeconds is greater than countdown, delete the reserve
                if($diffInSeconds > $countdown) {
                    $reserve->delete();
                }
            }
        }
    }
}
