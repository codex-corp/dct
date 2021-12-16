<?php

namespace App\Console;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $questions = Question::withCount(['answers' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subHours(24));
            }])->get();

            if (!$questions->isEmpty()) {
                foreach ($questions as $question) {
                    if ($question->answers_count > 0) {
                        //update status
                    }
                }
            }
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
