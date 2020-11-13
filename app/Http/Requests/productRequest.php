<?php


namespace App\Http\Requests;


class productRequest implements ControllerRequests
{

    public static function add(): array
    {
        // TODO: Implement add() method.
        return [
            'name'=>'required|string|max:255',
            'count'=>'required|numeric',
            'price'=>'required|numeric'
        ];
    }

    public static function edit(): array
    {
        // TODO: Implement edit() method.
        return [
            'id'=>'required|exists:products',
            'name'=>'string|max:255',
            'count'=>'numeric',
            'price'=>'numeric'
        ];
    }

    public static function delete(): array
    {
        // TODO: Implement delete() method.
        return [
            'id'=>'required|exists:products'
        ];
    }
}
