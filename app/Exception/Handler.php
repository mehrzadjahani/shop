<?php


namespace App\Exception;


use App\Exception\BankTransaction\BankTransactionEmptyBalance;
use App\Helper\ResponseJson;

class Handler
{
    public function render($exception)
    {

        if($exception instanceof BankTransactionEmptyBalance){
            return ResponseJson::failure("user balance is empty");
        }

    }
}
