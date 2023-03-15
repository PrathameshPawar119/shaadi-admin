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
        Schema::create('companies_cities', function (Blueprint $table) {
            $table->foreignId('companies_id')
                    ->constrained('companies')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('cities_id')
                    ->constrained('cities')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
            $table->unique(['companies_id', 'cities_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_cities');
    }
};
