<?php

namespace App\Http\Controllers;

use App\assign_remove_staff;
use App\Staff;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use InvalidConfirmationCode;

class StaffController extends MyController
{

    protected $staff = null;
    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function testMail() {
        Mail::raw('test email', function($mail) {
            $mail->to('shahzadshahg@hotmail.com','Shahzad')->subject('Welcome to Rypls Please find your password');
        });
    }

    public function createStaff(Request $request)
    {
        $fieldsValidation = [

            'staff_name' => 'required',
            'staff_phone' => 'required',
            'email_address' => 'required|unique:users,email_address',
        ];
        $validator = Validator::make($request->all(), $fieldsValidation);

        if ($validator->fails()) {
            $resultArray = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'dataArray' => []
            ];
        } else {
            $user = $this->staff->createStaff();
            $resultArray = ['status' => 1, 'message' => 'Staff created Successfully!', 'dataArray' => $user];
        }
        return Response::json($resultArray, 200);
    }

    public function getStaff($id)
    {
        $staff = DB::table('users')
            ->leftjoin('assign_remove_staff','assign_remove_staff.staff_name', '=', 'users.email_address')
            ->leftjoin('venues','venues.venue_name', '=', 'assign_remove_staff.venue_name')
            ->leftjoin('event','event.venue_id', '=', 'venues.id')
            ->groupBy('assign_remove_staff.venue_name','assign_remove_staff.staff_name')
            ->select(DB::raw(
                'users.*,
                users.id AS staff_login_id,
                IFNULL(venues.photo,"")AS photo,
                assign_remove_staff.event_name as assigned_event_id,
                IFNULL(venues.id,0) as venue_id,
                IFNULL(venues.venue_name,"") as venue_name,
                IFNULL(venues.special_note,"") as special_note,
                IFNULL(venues.user_id,0) as venue_owner,
                Count(event.id) as eventCount'))
            ->where('users.created_by', '=', $id)
            ->get();

        if(!$staff)
        {
            $resultArray = ['status' => 0, 'message' => 'Staff does not exist!','dataArray' => []];
            return Response::json( $resultArray,200);
        }
        $staff = $this->getEventCount($staff);
        $resultArray = ['status' => 1, 'message' => 'Staff list appeared Successfully!', 'dataArray' => $staff];
        return Response::json($resultArray, 200);
    }

    function getEventCount($list) {
        $eventCount = 0;
        $staff = [];
        foreach($list as $l) {

            $eventCount = DB::table('event')->select(DB::raw('Count(event.id) as eventCount'))->where('venue_id','=',$l->venue_id)->first();
            if($eventCount)
                $l->eventCount = $eventCount->eventCount;
            else
                $l->eventCount = 0;

            $staff [] = $l;
        }
        return $staff;
    }

    public function getVenuesLists($user_id)
    {
        $venues = DB::table('venues')->where('user_id', $user_id)->get();
        $venues = $this->getVenuesLikes($venues, $user_id);
        $resultArray = ['status' => 1, 'message' => 'Venues lists appeared Successfully!', 'dataArray' => $venues];
        return Response::json($resultArray, 200);
    }

    public function getEventLists(Request $request,$user_id)
    {
        $venue_name = $request->input('venue_name');
        if(!empty($venue_name)){
            $event = DB::table('assign_remove_staff')
                ->join('users','assign_remove_staff.staff_name', '=', 'users.email_address')
                ->join('event','assign_remove_staff.event_name','=','event.id')
                ->join('venues','venues.id', '=', 'event.venue_id')
                ->select('*', 'event.id AS event_id', 'users.id AS staff_login_id','venues.venue_name', 'venues.venue_address', 'venues.city','venues.state','venues.venue_phone','venues.venue_email','venues.venue_website')
                ->where('users.id',$user_id)
                ->where('assign_remove_staff.venue_name', '=',$venue_name)
                ->get();
        }
        else{
            $event = DB::table('assign_remove_staff')
                ->join('users','assign_remove_staff.staff_name', '=', 'users.email_address')
                ->join('event','assign_remove_staff.event_name','=','event.id')
                ->join('venues','venues.id', '=', 'event.venue_id')
                ->select('*', 'event.id AS event_id', 'users.id AS staff_login_id','venues.venue_name', 'venues.venue_address', 'venues.city','venues.state','venues.venue_phone','venues.venue_email','venues.venue_website')
                ->where('users.id',$user_id)
                ->get();
        }
        $event = $this->getEventsLikes($event, $user_id);

        $resultArray = ['status' => 1, 'message' => 'Events lists appeared Successfully!', 'dataArray' => $event];
        return Response::json($resultArray, 200);
    }
    public function staffAvailability(Request $request)
    {
        $staff_name = $request->input('staff_name');
        $event_name = $request->input('event_name');
        $venue_name = $request->input('venue_name');
        $availability = $request->input('availability');

        // get venue owner device id
        $user = DB::table('venues')
            ->join('users', 'users.id', '=', 'venues.user_id')
            ->where('venues.venue_name',$venue_name)
            ->first();

        // get staff name
        $staff = DB::table('users')
            ->where('email_address',$staff_name)
            ->first();

        $available = DB::table('assign_remove_staff')->where('staff_name',$staff_name)->where('venue_name',$venue_name)->where('event_name',$event_name)->first();
        if($available) {
            DB::table('assign_remove_staff')
                ->where('staff_name', $staff_name)
                ->where('event_name', $event_name)
                ->where('venue_name', $venue_name)
                ->update(['available' => $availability]);
        }
        else{
            $resultArray = ['status' => 0, 'message' => 'Something went wrong', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
        // get event name

        $event = DB::table('event')->where('id', '=', $event_name)->first();
        $is_available = ($availability == 'yes') ? 'available' : 'not available ';
        $push_message = 'Staff '.$staff->staff_name.' is '.$is_available.' for event: '.$event->event_name = (empty($event))?0:$event->event_name;
        $notification_status = $this->sendPushNotification($push_message, $user, 'android');
        $resultArray = ['status' => 1, 'message' => 'Staff availability updated', 'dataArray' => [], 'notification_status' => $notification_status];
        return Response::json($resultArray, 200);
    }
}
