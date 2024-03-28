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
        Schema::create('demo_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->integer('clicked')->comment('0=not clicked,1=clicked')->default('0');
            $table->integer('open')->comment('0=not open,1=open')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_emails');
    }
};
