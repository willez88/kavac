<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SystemMail;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $emails = explode(",", $request->toEmail);
        if (is_array($emails)) {
            foreach ($emails as $email) {
                Mail::to($email)->send(new SystemMail($request->subject, $request->message, $request->from));
            }
        } else {
            Mail::to($emails)->send(new SystemMail($request->subject, $request->message, $request->from));
        }
        return response()->json(['result' => true], 200);
    }
}
