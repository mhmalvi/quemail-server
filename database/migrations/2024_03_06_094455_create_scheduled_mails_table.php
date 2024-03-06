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
        Schema::create('scheduled_mails', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->integer('bounce_status')->comment("1=bounced, 0=not bounced");
            $table->bigInteger('user_id');
            $table->timestamp('schedule');
            $table->longText('template')->nullable();
            $table->text('subject')->nullable();
            $table->integer('delivery_status')->comment("1=delivered,0=pending");
            $table->unsignedBigInteger('scheduled_jobs_id');
            $table->foreign('scheduled_jobs_id')->references('id')->on('scheduled_jobs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_mails');
    }
};
