<?php


namespace App\Http\Requests;


class MerchantRequest implements ControllerRequests
{

    public static function add(): array
    {
        return [
            'shop_name'=>'required|string|max:255'
        ];
    }

    public static function edit(): array
    {
        return [
            'id'=>'required|exists:merchants',
            'shop_name'=>'string|max:255'
        ];
    }

    public static function delete(): array
    {

        return [
            'id'=>'required|exists:merchants',
        ];
    }
}
