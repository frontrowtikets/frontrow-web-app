<?php

use Illuminate\Http\Response as ResponseAlias;


function apiResponse($results, $status = ResponseAlias::HTTP_OK)
{
    return response()->json([
        "results" => $results,
    ], $status);
}
