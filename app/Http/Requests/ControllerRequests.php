<?php
namespace App\Http\Requests;

interface ControllerRequests {

    public static function add () : array;
    public static function edit () : array;
    public static function delete () : array;
}
