<?php

namespace App\Console\Commands;

use App\Models\ScheduledMail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleBulkMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-bulk-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MailSchedule';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mails = ScheduledMail::all();
        // print_r($mails);
        if ($mails) {
            foreach ($mails as $email) {
                $db_date = Carbon::parse($email->schedule)->format('Y-m-d');
                $today_date = Carbon::now()->format('Y-m-d');
                // print_r($db_date);
                // print_r($today_date);
                $db_time = Carbon::parse($email->schedule)->format('H:i');
                $today_time = Carbon::now()->format('H:i');
                // print_r($db_time);
                // print_r($today_time);
                if ($db_date <= $today_date && $email->delivery_status == 0 && $email->bounce_status == 0) {
                    if ($db_time <= $today_time) {
                        print_r('success');
                        print_r('true');
                    } else {
                        print_r('false');
                    }
                } else {
                    print_r('false');
                }
            }
        }
    }
}
