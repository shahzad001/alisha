<?php

namespace App;

use App\Http\Requests\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $hidden = ['remember_token','password'];
    protected $fillable = ['first_name','facebook_id','last_name','phone_number','email_address','password','user_type','staff_name','staff_phone'];

   public static function allUsers(){
       return self::all();
   }
    public function registerUser()
    {
        $input = Input::all();
        $input['password'] = Hash::make($input['password']);
        $user = new User();
        $user->fill($input);
        $user->save();
        return $user;
    }
    public function getUser($id)
    {
        $user = self::find($id);
        if(is_null($user))
        {
            return false;
        }
        return $user;
    }
    public function deleteUser($id)
    {
        $user = self::find($id);
        if(is_null($user))
        {
            return false;
        }
        return $user->delete();
    }
    public function updateUser($id)
    {
        $user = self::find($id);
        if(is_null($user))
        {
            return false;
        }
        $input = Input::all();
        if(isset($input['password']))
        {
            $input['password'] = Hash::make($input['password']);
        }

        $user->fill($input);
        $user->save();
        return $user;
    }

    public function venues()
    {
        return $this->hasMany('App\Venue');
    }
    public function recoverPassword()
    {
        $password = str_random(6);

        $input = Input::all();
        $staff_name = Input::get('staff_name');
        $staff_email = Input::get('email_address');

        DB::table('users')
            ->where('email_address', '=', $staff_email)
            ->update(['password' => Hash::make($password)]);

        $html = '<h2>Your password has been recovered Successfully</h2>';
        $html .= '<p>You can login on app with this username / password: </p>';
        $html .= '<p> <strong> Username: </strong>'.$staff_email.'</p>';
        $html .= '<p> <strong> Password: </strong>'.$password.'</p>';

        Mail::send(['html' => 'emails.view'],array('content' => $html), function($mail) {
            $mail->to(Input::get('email_address'),Input::get('staff_name'))->subject('Your password has been recovered Successfully');
        });

        return [];
    }
}
