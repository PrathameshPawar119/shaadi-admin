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
        Schema::create('tags_posts', function (Blueprint $table) {
            $table->foreignId('posts_id')
                    ->constrained('posts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('tags_id')
                    ->constrained('tags')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
            $table->unique(['posts_id', 'tags_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_posts');
    }
};
