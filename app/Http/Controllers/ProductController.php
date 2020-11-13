<?php

namespace App\Http\Controllers;

use App\Helper\ResponseJson;
use App\Http\Requests\productRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function add(Request $request)
    {
        $validated = $this->validate($request,productRequest::add());

        $product =$this->product_service->addProduct($validated);

        if($product){
            return ResponseJson::success('Item has been added successfully');
        }
        return ResponseJson::failure();
    }

    public function edit(Request $request,$id)
    {
        $request->merge(['id'=>$id]);
        $validated = $this->validate($request,productRequest::edit());

        $product = $this->product_service->findProductById($validated['id']);
        if($product->update($validated)){
           return ResponseJson::success('selected product detail has been updated');
        }
        return ResponseJson::failure();
    }

    public function delete(Request $request,$id)
    {
        $request->merge(['id'=>$id]);
        $validated = $this->validate($request,productRequest::delete());
        $product = $this->product_service->findProductById($validated['id']);
        if($product->delete()){
            ResponseJson::success('product item has been set to delete');
        }
        ResponseJson::failure();
    }

}
