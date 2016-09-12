<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class Staff extends Model
{
    protected $table = 'users';

    protected $fillable = ['staff_name','staff_phone','email_address','password','user_type','created_by'];
//    protected $hidden = ['password'];


    public static function allStaff()
    {
        return self::all();
    }

    public function createStaff()
    {
        $password = str_random(6);

        $input = Input::all();
        $staff_name = Input::get('staff_name');
        $staff_email = Input::get('email_address');
        $input['password'] = Hash::make($password);
        $staff = new Staff();
        $staff->fill($input);
        $staff->user_type = 'staff';
        $staff->save();

        $html = '<h2> Your account has been created on Rypls</h2>';
        $html .= '<p>You can login on app with this username / password: </p>';
        $html .= '<p> <strong> Username: </strong>'.$staff_email.'</p>';
        $html .= '<p> <strong> Password: </strong>'.$password.'</p>';

        Mail::send(['html' => 'emails.view'],array('content' => $html), function($mail) {
            $mail->to(Input::get('email_address'),Input::get('staff_name'))->subject('Welcome to Rypls');
        });
        return $staff;
    }
}

