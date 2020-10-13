<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // global options like color, size
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->text('title'); // translatable
        });
        // global values like red, white, black, big, small, M, XL, XXL
        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->text('title'); // translatable
        });
        // product variation or product itself
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->json('values'); // value ids
            $table->integer('stock');
            $table->integer('price');
            $table->text('photo_url');
            $table->integer('sale_price')->nullable();
            $table->timestamp('sale_start')->nullable();
            $table->timestamp('sale_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
        Schema::dropIfExists('values');
        Schema::dropIfExists('options');
    }
}
