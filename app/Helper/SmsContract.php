<?php
namespace App\Helper;


interface SmsContract {
    public static function sendSMS($to,$message);
}
