<?php


namespace App\Repositories;
use App\Models\Product;
use App\Models\User;

class ProductRepository
{
    public function addProduct(array $validated)
    {
        return Product::create($validated);
    }

    public function updateProduct(User $product,$fields_array): void
    {
        $product->update($fields_array);
    }

    public function findProductById($product_id)
    {
        return Product::find($product_id);
    }
}
