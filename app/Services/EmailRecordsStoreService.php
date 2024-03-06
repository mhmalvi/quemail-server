<?php

namespace App\Services;

use App\Models\EmailRecords;

class EmailRecordsStoreService{
    public $email;
    public $user_id;
    public $schedule;
    public $scheduled_jobs_id;

    public function __construct($email,$user_id,$schedule,$scheduled_jobs_id){
        $this->email=$email;
        $this->user_id=$user_id;
        $this->schedule=$schedule;
        $this->scheduled_jobs_id=$scheduled_jobs_id;
    }
    public function emailRecordsStore(){
        $email_records = new EmailRecords();
            $email_records->email=$this->email;
            $email_records->counts=0;
            $email_records->user_id=$this->user_id;
            $email_records->schedule=$this->schedule;
            $email_records->bounce=0;
            $email_records->scheduled_jobs_id=$this->scheduled_jobs_id;
            $email_records->save();
            return $email_records;
    }
}
