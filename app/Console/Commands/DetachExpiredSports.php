<?php

namespace App\Console\Commands;

use App\Models\Sport;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DetachExpiredSports extends Command
{
    protected $signature = 'sports:detach-expired';
    protected $description = 'Detach expired sports from users';

    public function handle()
    {
        $now = Carbon::now();

        // Get all sports with end_date less than or equal to the current date
        $expiredSports = Sport::whereHas('users', function ($query) use ($now) {
            $query->where('sport_user.end_date', '<=', $now);
        })->get();

        foreach ($expiredSports as $sport) {
            // Get all users who have the expired sport
            $users = $sport->users()->wherePivot('end_date', '<=', $now)->get();

            foreach ($users as $user) {
                // Detach the sport from the user
                $user->sports()->detach($sport->id);
            }
        }

        $this->info('Expired sports have been detached from users.');
    }
}
