<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * return response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message, $result, $status)
    {
    	$response = [
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, $status);
    }
}
