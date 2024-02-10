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
        Schema::create('dynamic_mails', function (Blueprint $table) {
            $table->id();
            $table->text('driver');
            $table->string('host');
            $table->integer('port');
            $table->string('username');
            $table->text('password');
            $table->text('encryption');
            $table->string('from_mail_address');
            $table->text('from_name');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_mails');
    }
};
