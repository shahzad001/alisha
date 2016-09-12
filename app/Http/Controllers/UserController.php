<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Reward;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function allUsers()
    {
        return Response::json($this->user->allUsers(), 200);
    }

    public function getUser($id) //1.  This function will display all current users with related message
    {
        $user = $this->user->getUser($id);
        if (!$user) {
            $resultArray = ['status' => 0, 'message' => 'User does not exist!'];
            return Response::json($resultArray, 200);
        }
        $resultArray = ['status' => 1, 'message' => 'User appeared Successfully!', 'dataArray' => $user];
        return Response::json($resultArray, 200);
    }

    public function registerUser(Request $request) //2.  This method will registered new users and will display the related message
    {
        $fieldsValidation = [

            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email_address' => 'required|unique:users,email_address',
            'password' => 'required|confirmed|min:6',
            'user_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $fieldsValidation);

        if ($validator->fails()) {
            $resultArray = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'dataArray' => []
            ];
        } else {
            $user = $this->user->registerUser();
            $resultArray = ['status' => 1, 'message' => 'User registered Successfully!', 'dataArray' => $user];
        }
        return Response::json($resultArray, 200);
    }

    public function updateUser($id) //3.  This function will provide the facility of update existing record
    {
        $user = $this->user->updateUser($id);
        if (!$user) {
            $resultArray = ['status' => 0, 'message' => 'User does not exist!'];
            return Response::json($resultArray, 200);
        }
        $resultArray = ['status' => 1, 'message' => 'User updated Successfully!', 'dataArray' => $user];
        return Response::json($resultArray, 200);
    }

    public function deleteUser($id) //4.  This function will delete the existing users
    {
        $user = $this->user->deleteUser($id);
        if (!$user) {
            $resultArray = ['status' => 0, 'message' => 'User does not exist!'];
            return Response::json($resultArray, 200);
        }
        $resultArray = ['status' => 1, 'message' => 'User removed Successfully!', 'dataArray' => $user];
        return Response::json($resultArray, 200);
    }

    public function verifyLogin(Guard $auth, Request $request)
    {
        $device_id = $request->input('device_id');
        $isVerified = $auth->attempt($request->only('email_address', 'password'), true);
        if ($isVerified) {
            $user = $auth->user()->toArray();
            $responseToReturn = [
                'status' => 1,
                'message' => 'User Logged-in Successfully!',
                'dataArray' => $user
            ];
            $reward = new Reward();
            $reward->getLoginPoint($user['id'], 'login', 5);
            DB::table('users')
                ->where('id', $user['id'])
                ->update(['device_id' => $device_id]);
            return Response::json($responseToReturn, 200);
        } else {
            $responseToReturn = [
                'status' => 0,
                'message' => 'Invalid Email / Password',
                'dataArray' => []
            ];
            return Response::json($responseToReturn, 200);
        }
    }
    public function loginWithFacebook(Request $request)
    {
        $fields = [
            'facebook_reference' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $fields);
        if($validator->fails()) {
            $resultArray = ['status' => 0, 'message' => $validator->errors()->first(), 'dataArray' => []];
        }
        $input = $request->only(array_keys($fields));
        if (!($logged_in_user = User::where(['facebook_id' => $input['facebook_reference']])->first())) {
            $logged_in_user = User::create([
                'first_name' => Input::get('first_name'),
                'last_name' => '',
                'phone_number' => '',
                'email_address' => '',
                'facebook_id' => $input['facebook_reference'],
                'user_type' => Input::get('user_type'),
                'password' => Hash::make(str_random(12)),
                'status' => 1
            ]);
        }
        $user = $logged_in_user->toArray();
        $resultArray = ['status' => 1, 'message' => 'Login with facebook successfully!!', 'dataArray' => $user];

        return Response::json($resultArray, 200);
    }
    public function changePassword(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = DB::table('users')->where('id', '=', $user_id)->first();
        $isCorrect = Hash::check($request->input('old_password'), $user->password);
        $new_password = ($request->input('new_password'));
        $confirm_password = ($request->input('password_confirmation'));

        if(!$isCorrect) {
            $resultArray = ['status' => 0, 'message' => 'Old password mismatch!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }

        if(empty($new_password)) {
            $resultArray = ['status' => 0, 'message' => 'New password cannot be empty', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }

        if($new_password != $confirm_password) {
            $resultArray = ['status' => 0, 'message' => 'Password & Confirm Password mismatch', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }

        DB::table('users')
            ->where('id', '=', $user_id)
            ->update(['password' => Hash::make($new_password)]);

        $resultArray = ['status' => 1, 'message' => 'Password Updated successfully!', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

     public function recoverPassword(Request $request)
     {
         $fieldsValidation = [
             'email_address' => 'required',
         ];
         $validator = Validator::make($request->all(), $fieldsValidation);

         if ($validator->fails()) {
             $resultArray = [
                 'status' => 0,
                 'message' => $validator->errors()->first(),
                 'dataArray' => []
             ];
         } else {
             $user = $this->user->recoverPassword();
             $resultArray = ['status' => 1, 'message' => 'Password recovered Successfully!', 'dataArray' => $user];
         }
         return Response::json($resultArray, 200);
     }

    public function showRewards(Request $request) {
        $user_id = $request->input('user_id');
        $list = [];
        $rippleList = $this->getRewardList($user_id, 'ripple');
        if(empty($rippleList)) {
            $rippleList = [
                "callCount" => 0,
                "reward_points" => 0,
                "user_id" => $user_id,
                "call_type" => "ripple"
            ];
        }
        $eventList = $this->getRewardList($user_id, 'event');
        if(empty($eventList)) {
            $eventList = [
                "callCount" => 0,
                "reward_points" => 0,
                "user_id" => $user_id,
                "call_type" => "event"
            ];
        }
        $loginList = $this->getRewardList($user_id, 'login');
        if(empty($loginList)) {
            $loginList = [
                "callCount" => 0,
                "reward_points" => 0,
                "user_id" => $user_id,
                "call_type" => "login"
            ];
        }
        $inviteFriend = $this->getRewardList($user_id, 'invite');
        if(empty($inviteFriend )) {
            $loginList = [
                "callCount" => 0,
                "reward_points" => 0,
                "user_id" => $user_id,
                "call_type" => "invite"
            ];
        }

        $list = [$rippleList, $eventList,$loginList,$inviteFriend];
        $resultArray = ['status' => 1, 'message' => 'Reward Point List', 'dataArray' => $list];
        return $resultArray;
    }

    private function getRewardList($user_id, $type) {
        $list = DB::table('rewards')
            ->select(DB::raw('
            COUNT(*) AS callCount,
            SUM(`reward_points`) AS reward_points,
            user_id,
            call_type
            '))
            ->where('user_id','=', $user_id)
            ->where('call_type','=', $type)
            ->groupBy('user_id','call_type')
            ->first();
        return $list;
    }
    public function inviteFriends($user_id)
    {
        $points = new Reward();
        $points->inviteFriends($user_id,'invite',20);
        $resultArray = ['status' => 1, 'message' => 'Friends have been invited Successfully', 'dataArray' => []];
        return $resultArray;
    }

    public function addComments()
    {
        $comment = new Comment();
        $comment->user_id          = Input::get('user_id');
        $comment->venue_id         = Input::get('venue_id');
        $comment->event_id         = Input::get('event_id');
        $comment->comments         = Input::get('comments');
        $isAdded = $comment->save();
        if($isAdded)
            $resultArray = ['status' => 1, 'message' => 'Comments added Successfully!', 'dataArray' => $comment];
        else
            $resultArray = ['status' => 0, 'message' => 'Unable to add comment! Please try again.', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }
    public function getCommentsLists(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');

        $comment = DB::table('comment')
            ->join('users','users.id', '=', 'comment.user_id')
            ->select(DB::raw('(CASE WHEN users.first_name = "" THEN users.staff_name ELSE users.first_name END) AS first_name, users.last_name, comment.user_id, comment.venue_id, comment.event_id, comment.comments, comment.created_at'))
            // ->where('user_id','=', $user_id)
            ->where('venue_id','=', $venue_id)
            ->where('event_id','=', $event_id)
            ->get();
        if($comment)
        $resultArray = ['status' => 1, 'message' => 'Comments list appeared Successfully!', 'dataArray' => $comment];
    else
        $resultArray = ['status' => 0, 'message' => 'No Comment found!', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }
    public function addUserSetting(Request $request)
    {
        $id = $request->input('id');
        $radius = $request->input('radius');
        $setting = DB::table('users')
            ->where('id', $id)
            ->update(['radius' => $radius]);
        if($setting)
            $resultArray = ['status' => 1, 'message' => 'Radius added Successfully!', 'dataArray' => []];
        else
            $resultArray = ['status' => 0, 'message' => 'Unable to add radius! Please try again.', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }
    public function getUserSetting(Request $request)
    {
        $id = $request->input('id');
        $setting = DB::table('users')
            ->where('id','=', $id)
            ->get();
        if($setting)
            $resultArray = ['status' => 1, 'message' => 'List appeared Successfully!', 'dataArray' => $setting];
        else
            $resultArray = ['status' => 0, 'message' => 'No list found!', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }
}