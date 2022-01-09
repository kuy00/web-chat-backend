<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\test;

class SocketController extends Controller
{
    public function test(Request $request)
    {
        $message = $request->input('message', 'no message');
        broadcast(new test($message));
    }
}
