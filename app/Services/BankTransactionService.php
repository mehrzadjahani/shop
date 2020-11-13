<?php


namespace App\Services;

use App\Exception\BankTransaction\BankTransactionEmptyBalance;

class BankTransactionService
{

    public function deposit($user,$amount,$description = '')
    {
        return $user->bankTransactions()->create([
            'amount' => $amount,
            'sum' => $user->balance() + $amount,
            'description' => $description
        ]);
    }

    public function withdraw($user,$amount,$description = '')
    {
        if($amount > $user->balance())
            abort(400);
//            throw new BankTransactionEmptyBalance();
        return $user->bankTransactions()->create([
            'amount' => $amount,
            'sum' => $user->balance() - $amount,
            'description' => $description
        ]);
    }
}
