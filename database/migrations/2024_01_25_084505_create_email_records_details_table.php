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
        Schema::create('email_records_details', function (Blueprint $table) {
            $table->id();
            $table->text('recipients_mail');
            $table->text('sender');
            $table->unsignedBigInteger('email_records_id');
            $table->foreign('email_records_id')->references('id')->on('email_records')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('open');
            $table->integer('click');
            $table->integer('subscribed_or_unsubscribed')->comments('1= subscribed, 0=unsubscribed')->default(1);
            $table->dateTime('schedule')->nullable();
            $table->integer('bounce_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_records_details');
    }
};
