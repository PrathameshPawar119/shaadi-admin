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
        Schema::create('companies_posts', function (Blueprint $table) {
            $table->foreignId('companies_id')
                    ->constrained('companies')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('posts_id')
                    ->constrained('posts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
            $table->unique(['companies_id', 'posts_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_posts');
    }
};
