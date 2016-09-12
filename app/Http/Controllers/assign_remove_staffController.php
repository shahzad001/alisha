<?php

namespace App\Http\Controllers;

use App\assign_remove_staff;
use App\Staff;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class assign_remove_staffController extends MyController
{

    protected $assignStaff = null;
    public function __construct(assign_remove_staff $assignStaff)
    {
        $this->assignStaff = $assignStaff;
    }

    public function assignStaff(Request $request)
    {
        $id = $request->input('staff_name');

        // get staff device id
        $user = DB::table('users')
            ->where('email_address',$id)
            ->first();

        // get venue owner
        $venue_owner = DB::table('venues')
            ->select('first_name', 'last_name', 'venue_name')
            ->join('users', 'users.id', '=', 'venues.user_id')
            ->where('venues.venue_name','=', trim($request->input('venue_name')))
            ->first();

        $event_id = $request->input('event_name');
        $staff = [];
        $isAlready = DB::table('assign_remove_staff')->where('staff_name', '=', $id)->where('event_name', '=', $event_id)->count();
        if($isAlready > 0) {
            DB::table('assign_remove_staff')->where('staff_name', '=', $id)->where('event_name', '=', $event_id)->delete();
            $message = 'Staff has been removed Successfully!';
            $assigned = 'removed you from ';
        } else {
            $staff = $this->assignStaff->assignStaff();
            $message = 'Duties has been assigned to staff Successfully!';
            $assigned = 'assigned you a ';
        }

        // get event name
        $event = DB::table('event')->where('id', '=', $event_id)->first();
        $role = $request->input('staff_role');

        $owner  = $venue_owner->first_name.' '.$venue_owner->last_name;
        $push_message = $owner.' has '.$assigned.' role of "'.$role.'" in event "'.$event->event_name.'" on venue '.$venue_owner->venue_name;

        $notification_status = $this->sendPushNotification($push_message, $user, 'android');
        $resultArray = ['status' => 1, 'message' => $message, 'dataArray' => $staff,  'notification_status' => $notification_status];
        return Response::json($resultArray, 200);
    }
}
