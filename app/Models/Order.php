<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];


    public function products()
    {
        return $this->belongsToMany(Product::class,'order_items');
    }

    public function calculatePrice()
    {
        $price = 0;
        foreach ($this->products as $product)
            $price += $product->price;
        $this->price = $price;
        $this->save();
        return $price;
    }
}
