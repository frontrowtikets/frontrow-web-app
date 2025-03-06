<?php

use Illuminate\Http\Response as ResponseAlias;
use App\Jobs\ProcessSendQueueEmail;
use Illuminate\Support\Facades\Log;

// constants 
define('BEYONIC_CLIENT_VERSION', '0.0.16');


function apiResponse($results, $status = ResponseAlias::HTTP_OK)
{
    return response()->json([
        "results" => $results,
    ], $status);
}

function apiErrorResponse($message, $errors = [], $status = ResponseAlias::HTTP_BAD_REQUEST)
{
    return response()->json([
        "message" => $message,
        "errors" => $errors
    ], $status);
}

function sendQueueMail($mail, $sendTo)
{
    try {

        ProcessSendQueueEmail::dispatch($mail, $sendTo)->onQueue("emails");
    } catch (\Exception $e) {
        Log::error("Sending email failed");
    }
}
