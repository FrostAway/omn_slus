<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\DemoCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function() {
            $items = DB::table('customers_passports')->select('passport_id', 'next_passport_id')->get();
            if (count($items) > 0) {
                $date_time = date('Y-m-d H:i:s');
                foreach ($items as $item) {
                    if ($item->next_passport_id) {
                        $passport = DB::table('passports')->find($item->next_passport_id, ['price']);
                        DB::table('customers_passports')
                                ->where('passport_id', $item->passport_id)
                                ->update([
                                    'passport_id' => $item->next_passport_id,
                                    'amount' => $passport->price,
                                    'from_date' => $date_time,
                                    'to_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
                                    'auth_date' => $date_time,
                                    'set_date' => $date_time,
                                    'mtime' => $date_time
                                ]);
                    } else {
                        DB::table('customers_passports')->where('passport_id', $item->passport_id)->whereNull('next_passport_id')->delete();
                    }
                }
            }
            echo 'updated';
        })->monthlyOn(1, '0:0');
    }

}
