<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //creazione per FK e il coollegamento 
            $table->unsignedBigInteger('category_id')->nullable()->after('id'); // fk

            $table->foreign('category_id') //creazione collegamento
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_category_id_foreign'); //eliminare la linea di collegamento tra tabelle

            $table->dropColumn('category_id'); // eliminare la colonna

        });
    }
}
