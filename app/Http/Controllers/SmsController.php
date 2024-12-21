<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class SmsController extends Controller
{
    public function sendsms(Request $request)
    {
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_TOKEN');
        $sendernumber = getenv('TWILIO_PHONE');

        $twilio = new Client($sid, $token);

        $phoneNumber = $request->input('phoneNumber');

        // Generate a random number
        $randomNumber = rand(100000, 999999);

        // Store the OTP in the cache for 5 minutes
        Cache::put($phoneNumber, $randomNumber, 300);

        // Create the message body with the random number
        $messageBody = "Your verification code is " . $randomNumber;

        try {
            $message = $twilio->messages->create(
                $phoneNumber, // Recipient's phone number
                [
                    "body" => $messageBody,
                    "from" => $sendernumber
                ]
            );
            return response()->json(['message' => 'Message sent successfully!', 'sid' => $message->sid], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function verifyOtp(Request $request)
    {
        $phoneNumber = $request->input('phoneNumber');
        $otp = $request->input('otp');

        // Check the OTP
        $cachedOtp = Cache::get($phoneNumber);

        if ($cachedOtp == $otp) {
            // OTP is correct, proceed to log in
            return response()->json(['message' => 'OTP verified successfully!'], 200);
        } else {
            // OTP is incorrect
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
    }
}

