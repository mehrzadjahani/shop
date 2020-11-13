<?php


namespace App\Helper;


use Illuminate\Support\Facades\Http;

class Helper
{
    public static function sendSMS($to,$message)
    {
        $result = Http::get("http://188.0.240.110/class/sms/webservice/send_url.php?from=+98100020400&to=$to&msg=" . urlencode($message) . "&uname=hamidreza9213&pass=" . urlencode("haj hamid"));
        return $result->ok();
    }
}
