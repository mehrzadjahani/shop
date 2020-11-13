<?php


namespace App\Services;



use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    private $product_Repository;
    // *** soal , chera inja intori class ro moarefi mikonim b service mun?!
    public function __construct(ProductRepository $product_Repository)
    {
        $this->product_Repository = $product_Repository;
    }


    //add product to db
    public function addProduct(array $validated)
    {
        return $this->product_Repository->addProduct($validated);
    }


    //find product in db
    public function findProductById($productID)
    {
        return $this->product_Repository->findProductById($productID);
    }


    //update product in db
    public function updateProduct(Product $product,$fields_array): void
    {
        $this->updateProduct($product,$fields_array);
    }


}
