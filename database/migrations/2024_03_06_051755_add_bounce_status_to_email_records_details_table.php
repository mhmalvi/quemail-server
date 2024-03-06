<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_records_details', function (Blueprint $table) {
            $table->integer('bounce_status')->nullable()->comment('1=bounced,0=not_bounced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_records_details', function (Blueprint $table) {
            //
        });
    }
};
