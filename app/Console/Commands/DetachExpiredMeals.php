<?php

namespace App\Console\Commands;

use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DetachExpiredMeals extends Command
{
    protected $signature = 'meals:detach-expired';
    protected $description = 'Detach users from expired meals';

    public function handle()
    {
        $now = Carbon::now();

        // Get meals that have expired based on the date column in the pivot table
        $expiredMeals = Meal::whereHas('users', function ($query) use ($now) {
        $query->where('meal_user.date', '<=', $now);
    })->get();

        foreach ($expiredMeals as $meal) {
            // Detach the meal from users
            $meal->users()->detach();

            $this->info("Detached users from expired meal {$meal->name}");
        }

        $this->info('Detachment of expired meals completed.');
    }
}
