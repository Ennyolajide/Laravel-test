<?php

namespace App\Http\Controllers;


use App\Models\Email;
use App\Jobs\ProcessEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Validator;


class SendEmailController extends Controller
{
    //

    public function sendEmail(Request $request){

        $validator = Validator::make($request->all(), [
            'emails.*.subject' => 'required|string',
            'emails.*.body' => 'required|string',
            'emails.*.email' => 'required|string|email',
            'emails.*.base64_attachments' => 'string|array',
            'emails.*.fake' => 'required|string|array',
        ]);

        foreach($request->emails as $mailData){
            $mailData = (object) $mailData;
            ProcessEmail::dispatch($request->user(),$mailData);
        }

        return response()->json([
            'status' => 'Processing',
        ]);

    }

    public function list(Request $request){
        return response()->json([
            'emails' => Email::where('user_id',$request->user()->id)->whereStatus(true)->with('attachments')->get()
        ]);
    }
}
