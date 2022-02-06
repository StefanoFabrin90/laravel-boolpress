<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            //fk per i post
            $table->unsignedBigInteger('post_id'); // FK
            $table->foreign('post_id') // linea di collegamento
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            //fk per i tag
            $table->unsignedBigInteger('tag_id'); //FK
            $table->foreign('tag_id') // linea di collegamento
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
