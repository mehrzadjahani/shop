<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * @test
     */
    public function it_can_add_new_product()
    {
        $product = factory(\App\Models\Product::class)->raw();
        $response = $this->post(route('add_product'),$product);
        $response->assertResponseStatus(200);

    }

    /**
     * @test
     */
    public function it_can_edit_product()
    {
        $product = factory(\App\Models\Product::class)->create();
        $response = $this->put('product/edit/'.$product->id,[
            'count'=> 3
        ]);
        $found_obj =  \App\Models\Product::where('id',$product->id)->where('count','3')->first();
        //$this->assertTrue(!is_null($found_obj));
        $response->assertResponseStatus(200);

    }

}
