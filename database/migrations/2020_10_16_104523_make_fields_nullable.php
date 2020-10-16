<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_price');
            $table->dropColumn('address');
            $table->dropColumn('region');
            $table->dropColumn('city');
            $table->dropColumn('delivery');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('delivery_price')->nullable()->default(0);
            $table->text('address')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('delivery')->nullable();
        });
        Schema::table('products', function(Blueprint $table) {
            $table->dropColumn('views');
        });
        Schema::table('products', function(Blueprint $table) {
            $table->bigInteger('views')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->dropColumn('views');
        });
        Schema::table('products', function(Blueprint $table) {
            $table->integer('views')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_price');
            $table->dropColumn('address');
            $table->dropColumn('region');
            $table->dropColumn('city');
            $table->dropColumn('delivery');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('delivery_price');
            $table->text('address');
            $table->string('region');
            $table->string('city');
            $table->string('delivery');
        });
    }
}