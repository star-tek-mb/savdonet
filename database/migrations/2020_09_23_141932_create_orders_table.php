<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // for future
            $table->integer('delivery_price'); // total price = delivery_price + sum(order_products.price)
            $table->text('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('region_city');
            $table->text('address');
            $table->text('comment')->nullable();
            $table->string('status'); // created, paid (if prepaid), delivering, done, cancelled
            $table->timestamps();
        });
        Schema::create('order_products', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // delete if order deleted
            $table->foreignId('product_variation_id')->nullable()->constrained()->onDelete('set null'); // set null, but remember price and quantity
            $table->integer('price'); // save price for sale
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
    }
}
