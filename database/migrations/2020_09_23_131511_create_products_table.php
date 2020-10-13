<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->json('options')->nullable(); // if empty - one variation defines price and stock
            $table->text('title'); // translatable
            $table->text('description'); // translatable
            $table->json('media')->nullable(); // array of images
            $table->text('seo')->nullable(); // maybe json, maybe text
            $table->integer('views')->nullable(); // increment each time when presented
            $table->string('status')->nullable(); // visible
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
        Schema::dropIfExists('products');
    }
}
