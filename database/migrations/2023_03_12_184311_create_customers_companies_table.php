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
        Schema::create('customers_companies', function (Blueprint $table) {
            $table->foreignId('customers_id')
                        ->constrained('customers')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreignId('companies_id')
                        ->constrained('companies')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');

            $table->unique(['customers_id', 'companies_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_companies');
    }
};
