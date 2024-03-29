<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('email')->unique();
            $table->string('contact')->nullable()->unique();
            $table->boolean('has_whatsapp')->default(false);
            $table->string('alt_contact')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('contact_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('city');
            $table->rememberToken();
            $table->string('referrer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractors');
    }
};
