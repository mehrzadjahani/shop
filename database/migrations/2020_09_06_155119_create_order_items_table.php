<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public $table_name = 'order_items';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->foreign('product_id',$this->table_name.'_product_id')->on('products')
                ->references('id')->onUpdate('restrict')->onDelete('restrict');

            $table->unsignedBigInteger('order_id')->nullable()->default(null);
            $table->foreign('order_id',$this->table_name.'_user_id')->on('orders')
                ->references('id')->onUpdate('restrict')->onDelete('restrict');

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
        Schema::dropIfExists($this->table_name);
    }
}
