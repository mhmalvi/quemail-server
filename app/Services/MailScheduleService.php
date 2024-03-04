<?php

namespace App\Services;

use App\Models\ScheduledMail;

class MailSchedule
{

    // public function __construct()
    // {
    // }
    public function schedule()
    {
        $scheduler = new ScheduledMail();
        return $scheduler;
    }
}
