<?php

use App\Models\Product;
use App\Models\User;
use App\Services\BankTransactionService;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrderControllerTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_should_return_exception_on_unauthenticated_call()
    {

        $response = $this->call('POST', route('add_order'));

        $this->assertEquals(401, $response->status());
    }

    /**
     * @test
     */
    public function it_should_return_exception_on_empty_call()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->call('POST', route('add_order'));

        $this->assertEquals(422, $response->status());
    }

    /**
     * @test
     */
    public function it_should_return_error_on_empty_credit()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        app(BankTransactionService::class)->deposit(
            $user,
            100
        );

        $product_1 = factory(Product::class)->create([
            'price'=>100
        ]);

        $response = $this->call('POST', route('add_order'),[
            'product_ids'=>[$product_1->id],
            'payment_type'=>'credit'
        ]);


        $this->assertEquals(200, $response->status());


    }
}
