<?php

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;

if (!function_exists('date_formet')) {

    /**
     * Format date like: 28 Jan 2029
     *
     * @param string|datetime $date
     * @return string|null
     */
    function date_formet($date)
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->format('d M Y');
    }
}

if (!function_exists('email_temp')) {
    function email_temp($name)
    {
        return EmailTemplate::where('name', $name)->first();
    }
}

if (!function_exists('send_email')) {

    function send_email(string $to, string $templateName, array $data = [])
    {
        try {

            Mail::to($to)->send(
                new OtpMail($templateName, $data)
            );

            return true;

        } catch (\Exception $e) {

            return false;
        }
    }
}

if (!function_exists('send_whatsapp_otp')) {

    function send_whatsapp_otp($phone, $otp)
    {
        $message = "Your OTP is: ".$otp;

        $phone = '91'.$phone;

        $url = "https://wa.me/".$phone."?text=".urlencode($message);

        return $url;
    }
}
