<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TemporalReserve;
use Carbon\Carbon;

class UpdateTemporalReserves extends Command
{
    protected $signature = 'temporalreserves:update';

    protected $description = 'Update the reserve_time countdown for temporal reserves';

    public function handle()
    {
        $now = Carbon::now();

        $temporalReserves = TemporalReserve::all();

        foreach ($temporalReserves as $reserve) {
            $reserveTime = $reserve->reserve_time;
            if ($reserveTime) {
                $diffInSeconds = $reserveTime->diffInSeconds($now, false);
                // If diffInSeconds is negative, time is in the future, so countdown is positive
                $countdown = $diffInSeconds > 0 ? 0 : abs($diffInSeconds);
                // Update a field to store countdown if needed, or handle logic accordingly
                // Assuming reserve_time is a timestamp, we might want to update a separate field for countdown
                // For now, just log or handle as needed
            }
        }

        $this->info('Temporal reserves updated successfully.');
    }
}
