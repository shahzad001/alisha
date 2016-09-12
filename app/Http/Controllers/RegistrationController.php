<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RegistrationController extends Controller
{
    public function postRegister(Request $request, \AppMailer $mailer)
    {
        $this->validate($request, [
            'staff_name' => 'required',
            'email_address' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($request->all());

        $mailer->sendEmailConfirmationTo($user);

        $resultArray = ['status' => 1, 'message' => 'Staff Created!', 'dataArray' => [] ];
        return Response::json($resultArray, 200);
    }
    public function confirmEmail($token)
    {
        User::whereToken($token)->firstOrFail()->confirmEmail();
    }
}
