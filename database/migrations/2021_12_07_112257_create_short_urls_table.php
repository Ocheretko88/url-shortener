<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->unsigned()->default(0);
             $table->text('url');
             $table->string('short_key')->unique()->nullable();
             $table->string('custom_short_key')->unique()->nullable();
             $table->boolean('is_enabled')->default(true);
             $table->integer('clicks')->default(0);
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
        Schema::dropIfExists('short_urls');
    }
}
