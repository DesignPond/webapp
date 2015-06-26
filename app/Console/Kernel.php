<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
        'App\Console\Commands\SendChange',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('change:send --interval=day')->dailyAt('20:00');
        $schedule->command('change:send --interval=week')->weeklyOn(4, '20:00');
        $schedule->command('change:send --interval=month')->cron('0 20 1 * * *');

        $schedule->command('queue:work')->cron('* * * * *');
	}

}
