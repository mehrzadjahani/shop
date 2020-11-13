<?php


namespace App\Http\Requests;


class UserRequest implements ControllerRequests
{

    public static function add(): array
    {
       return  [
           'full_name'=> 'required|string|max:100',
           'phone_number'=> array('required','string','regex:/09\d{9}/'),
           'password'=> array('confirmed','required','string','regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/'),
       ];
    }

    public static function edit(): array
    {
        return  [
            'id'=>'required|exists:users,id',
            'full_name'=> 'string|max:100',
            'phone_number'=> array('string','regex:/09\d{9}/'),
            'password'=> array('confirmed','string','regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/'),
        ];
    }

    public static function delete(): array
    {
        return [
            'id'=>'required|exists:users,id',
        ];
    }
}
