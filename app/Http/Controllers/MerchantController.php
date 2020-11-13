<?php

namespace App\Http\Controllers;

use App\Helper\ResponseJson;
use App\Http\Requests\MerchantRequest;
use Illuminate\Http\Request;

class MerchantController extends Controller
{

    public function add(Request $request)
    {
        $validated = $this->validate($request,MerchantRequest::add());

        $merchant = auth()->user()->merchant()->create($validated);

        if($merchant){
            ResponseJson::success();
        }
        ResponseJson::failure();


    }

    public function edit(Request $request,$id)
    {
        $request->merge(['id'=>$id]);
        $validated = $this->validate($request,MerchantRequest::edit());

        $merchant = auth()->user()->merchant()->find($id)->update($validated);

        if($merchant){
            ResponseJson::success();
        }
        ResponseJson::failure();
    }

    public function delete(Request $request,$id)
    {
        $request->merge(['id'=>$id]);
        $this->validate($request,MerchantRequest::delete());

        $merchant = auth()->user()->merchant()->find($id)->delete();

        if($merchant){
            ResponseJson::success();
        }
        ResponseJson::failure();
    }

}
