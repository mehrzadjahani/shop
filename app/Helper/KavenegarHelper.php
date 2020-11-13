<?php


namespace App\Helper;


use Illuminate\Support\Facades\Log;
use Kavenegar\KavenegarApi;

class KavenegarHelper implements SmsContract
{

    public static function sendSMS($to,$message)
    {
        try {
            $kavenegar = new KavenegarApi(env('KAVENEGAR_API_KEY'));
            $sender = "10008663";
            $receptor = $to;
            $kavenegar->Send($sender,$receptor,$message);
        return true;


        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }
    }
}
