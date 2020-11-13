<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public $table_name = 'products';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('count')->default(0);
            $table->float('price')->default(0);
            $table->unsignedBigInteger('merchant_id')->nullable()->default(null);

            $table->foreign('merchant_id',$this->table_name.'_merchant_id')->on('merchants')
                ->references('id')->onUpdate('restrict')->onDelete('restrict');
            $table->boolean('active')->default(1);
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
