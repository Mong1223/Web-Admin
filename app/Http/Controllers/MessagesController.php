<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function SendMessage(Request $request)
    {
        $login = LoginController::class;
    }
}
