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
            $table->integer('subscribed_or_unsubscribed')->comments('1= subscribed, 0=unsubscribed')->default(1);
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
