<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('sum')->default(0);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id','bank_transaction_user_id')->on('users')
                ->references('id')->onUpdate('restrict')->onDelete('restrict');
            $table->string('description');
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
        Schema::dropIfExists('bank_transactions');
    }
}
