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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('about')->nullable();
            $table->string('email')->unique();
            $table->json('services')->nullable();
            $table->string('website')->nullable()->unique();
            $table->string('industry_type');
            $table->string('main_city')->nullable();
            $table->json('available_cities')->nullable();
            $table->string('company_size')->nullable();
            $table->timestamp("founded")->default(now());
            $table->integer('followers')->default(0);
            $table->integer('reports')->default(0);
            $table->unsignedBigInteger('creator');
            $table->foreign('creator')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('companies');
    }
};
