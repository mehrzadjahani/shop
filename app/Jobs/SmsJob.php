<?php

namespace App\Jobs;

use App\Helper\Helper;
use App\Helper\KavenegarHelper;

class SmsJob extends Job
{
    public $to;
    public $message;

    /**
     * SmsJob constructor.
     * @param $to
     * @param $message
     */
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {

        $result = KavenegarHelper::sendSMS($this->to,$this->message);
        if(!$result)
            throw new \Exception();

    }
}
