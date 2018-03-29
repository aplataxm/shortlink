<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortenedLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortened_links', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('author_id');
            $table->string('original_url');
            $table->string('shortened_url');
            $table->unsignedInteger('views_count');
            $table->string('token', 191)->unique();

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
        Schema::dropIfExists('shortened_links');
    }
}
