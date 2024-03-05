<?php

namespace App\Console\Commands;

use App\Models\ScheduledMail;
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
    protected $description = 'Bal Mail Schedule';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mails = ScheduledMail::all();
    }
}
