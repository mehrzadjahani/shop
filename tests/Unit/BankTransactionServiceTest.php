<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\BankTransactionService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BankTransactionServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_deposit_method()
    {

        $this->hasMethod(BankTransactionService::class, 'deposit');
    }


}
