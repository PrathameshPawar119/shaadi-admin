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
        Schema::create('customers', function (Blueprint $table) {
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
            $table->boolean('hasCompany')->default(false);
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
        Schema::dropIfExists('customers');
    }
};
