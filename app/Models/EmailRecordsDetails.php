<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailRecordsDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'email_records_details';
}
