<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('shop_name');
            $table->text('address');
            $table->string('phone');
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('supplier_id');
        });
        Schema::dropIfExists('suppliers');
    }
}
