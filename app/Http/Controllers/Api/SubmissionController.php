<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SubmissionMail;
use App\Models\Submission;
use Illuminate\Http\Request;
use Mail;

/**
 * @hideFromAPIDocumentation
 */
class SubmissionController extends Controller
{
    public function send(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email:rfc,strict,dns,filter',
            'message' => 'required|string|min:15',
        ]);

        // Create model
        $submission = Submission::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'message' => $validate['message'],
        ]);

        $from_address = config('mail.from.address');

        // Send mail
        Mail::send(new SubmissionMail(submission: $submission));

        return response()->json([
            'success' => 'Your mail was sended!',
            'contact' => [
                'from' => $from_address,
            ],
        ], 200);
    }
}
