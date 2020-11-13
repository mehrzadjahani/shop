<?php

use App\Models\Order;
use App\Models\Product;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_calculate_method()
    {

        $this->hasMethod(Order::class,'calculatePrice');
    }


    /**
     * @dataProvider prices
     */
    public function test_order_is_calculate_correctly($p1,$p2,$sum)
    {

        $order = factory(Order::class)->create();

        $product_1 = factory(Product::class)->create([
            'price'=>$p1
        ]);
        $product_2 = factory(Product::class)->create([
            'price'=>$p2
        ]);

        $order->products()->attach($product_1->id);
        $order->products()->attach($product_2->id);

        $order->calculatePrice();
        $this->assertEquals($sum,$order->price);
    }

    public function prices()
    {
        return [
            [0,1000,1000],
            [200,300,500],
            [1,99,100]
        ];
    }


}
