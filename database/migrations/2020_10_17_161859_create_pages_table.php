<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->nullable()->default(1); // to sort in menu
            $table->string('slug');
            $table->text('title'); // translatable
            $table->text('description'); // translatable
            $table->text('seo')->nullable();
            $table->integer('views')->nullable()->default(0); // increment each time when presented
            $table->string('status')->nullable(); // hidden?
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
        Schema::dropIfExists('pages');
    }
}
