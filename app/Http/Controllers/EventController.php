<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventRating;
use App\Image;
use App\Reward;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    protected $event = null;

    public function __construct(Event $event)
    {
        error_reporting(E_ALL);
        $this->event = $event;
    }

    public function allEvents()
    {
        return Response::json($this->event->allEvent(), 200);
    }

    public function getEvent($id) // 1. This function will return all events against their ids with session message
    {
        // get user type:
        $user_type = User::findOrFail($id);

        $user_lat = Input::get('latitude');
        $user_long = Input::get('longitude');
        $user_radius = Input::get('user_radius');

        if(empty($user_radius) || $user_radius == 0)
            $user_radius = 100;
        $event = [];


        if($user_type->user_type == 'user') {
            if (empty($user_lat) || empty($user_long)) {
                $event = DB::table('event')
                    ->join('venues', 'venues.id', '=', 'event.venue_id')
                    ->select(DB::raw('event.*,venues.latitude,venues.longitude, venues.venue_name, venues.venue_address, venues.city, venues.state, venues.venue_phone, venues.venue_email, venues.venue_website'))
                    ->get();
            } else {
                $event = DB::table('event')
                    ->join('venues', 'venues.id', '=', 'event.venue_id')
                    ->select(DB::raw('event.*,venues.latitude,venues.longitude, venues.venue_name, venues.venue_address, venues.city, venues.state, venues.venue_phone, venues.venue_email, venues.venue_website, ' . $this->radiusQuery($user_lat, $user_long)))
                    ->having('distance_miles', '<=', $user_radius)
                    ->get();
            }
        } else if($user_type->user_type == 'staff'){
            if (empty($user_lat) || empty($user_long)) {
                $event = DB::table('event')
                    ->join('venues', 'venues.id', '=', 'event.venue_id')
                    ->join('assign_remove_staff', 'assign_remove_staff.event_name', '=', 'event.id')
                    ->join('users', 'users.email_address', '=', 'assign_remove_staff.staff_name')
                    ->select(DB::raw('event.*,venues.latitude,venues.longitude, venues.venue_name, venues.venue_address, venues.city, venues.state, venues.venue_phone, venues.venue_email, venues.venue_website'))
                    ->where('users.id','=', $id)
                    ->get();
            } else {
                $event = DB::table('event')
                    ->join('venues', 'venues.id', '=', 'event.venue_id')
                    ->join('assign_remove_staff', 'assign_remove_staff.event_name', '=', 'event.id')
                    ->join('users', 'users.email_address', '=', 'assign_remove_staff.staff_name')
                    ->select(DB::raw('event.*,venues.latitude,venues.longitude, venues.venue_name, venues.venue_address, venues.city, venues.state, venues.venue_phone, venues.venue_email, venues.venue_website'))
                    ->having('distance_miles', '<=', $user_radius)
                    ->where('users.id','=', $id)
                    ->get();
            }
        } else {
            if (empty($user_lat) || empty($user_long)) {
                $event = DB::table('event')
                    ->join('venues', 'venues.id', '=', 'event.venue_id')
                    ->select(DB::raw('event.*,venues.latitude,venues.longitude, venues.venue_name, venues.venue_address, venues.city, venues.state, venues.venue_phone, venues.venue_email, venues.venue_website'))
                    ->where('venues.user_id','=', $id)
                    ->get();
            } else {
                $event = DB::table('event')
                    ->join('venues', 'venues.id', '=', 'event.venue_id')
                    ->select(DB::raw('event.*,venues.latitude,venues.longitude, venues.venue_name, venues.venue_address, venues.city, venues.state, venues.venue_phone, venues.venue_email, venues.venue_website, ' . $this->radiusQuery($user_lat, $user_long)))
                    ->where('venues.user_id','=', $id)
                    ->having('distance_miles', '<=', $user_radius)
                    ->get();
            }
        }
        if (!$event) {
            $resultArray = ['status' => 0, 'message' => 'No record found!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
        else {
            $event = $this->getEventsLikes($event, $id);
        }
        $reward = new Reward();
        $reward->getEventPoint($user_type->id, 'event', 5);
        $resultArray = ['status' => 1, 'message' => 'Events list appeared Successfully!', 'dataArray' => $event];
        return Response::json($resultArray, 200);
    }

    public function registerEvent(Request $request)// 2.  This function will register the new event
    {
        $fieldsValidation = [
            'user_id' => 'required',
            'venue_id' => 'required',
            'event_name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'event_type' => 'required',
            'music_type' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'age_restriction' => 'required',
            'parking' => 'required',
            'phone' => 'required',
            'facebook_url' => 'required',
            'twitter_url' => 'required',
            'youtube_url' => 'required',
            'recurring' => 'required',
        ];
        $validator = Validator::make($request->all(), $fieldsValidation);

        if ($validator->fails()) {
            $resultArray = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'dataArray' => []
            ];
        } else {
            /*
             * date check
             */
            $date_from = date('d M Y', strtotime($request->input('date_from'))); // 16 Dec 1970
            $date_to = date('d M Y', strtotime($request->input('date_to')));

            if(strstr($date_from,'1970') || strstr($date_from,'1969') || strstr($date_to,'1970' || strstr($date_to,'1969'))) {
                $resultArray = ['status' => 1, 'message' => 'Invalid Event Date', 'dataArray' => []];
                return Response::json($resultArray, 200);
            }
            /*
             * time check
             */
            $time_from = $request->input('time_from');
            $time_to = $request->input('time_to');


            if(stristr($time_from,'Select Time') || stristr($time_to,'Select Time')) {
                $resultArray = ['status' => 1, 'message' => 'Invalid Event Time', 'dataArray' => []];
                return Response::json($resultArray, 200);
            }
            $images = [];
            if ($request->hasFile('photo'))
            {
                $files = \Illuminate\Support\Facades\Request::file('photo');
                $image_path = public_path().'/images/';
                $images = [];
                foreach($files as $file){
                    $image_name = 'event_'.Carbon::now()->toDateString().rand().'.'.$file->getClientOriginalExtension();
                    $file->move($image_path,$image_name);
                    $images[]=$image_name;
                }
            }
            $isAlreadyExist = DB::table('event')->where('venue_id', Input::get('venue_id'))
                ->where('date_from', $date_from)
                ->where('event_name', Input::get('event_name'))->count();

            if($isAlreadyExist > 0) {
                $resultArray = ['status' => 1, 'message' => 'You cannot create same event on same day', 'dataArray' => []];
                return Response::json($resultArray, 200);
            }
            $event = new Event();
            $event->venue_id      = Input::get('venue_id');
            $event->user_id      = Input::get('user_id');
            $event->event_name      = Input::get('event_name');
            $event->title      = Input::get('title');
            $event->description = Input::get('description');
            $event->event_type = Input::get('event_type');
            $event->music_type = Input::get('music_type');
            $event->price = Input::get('price');
            $event->date_from = $date_from;
            $event->date_to = $date_to;
            $event->time_from = $time_from;
            $event->time_to = $time_to;
            $event->age_restriction = Input::get('age_restriction');
            $event->parking = Input::get('parking');
            $event->phone = Input::get('phone');
            $event->facebook_url = Input::get('facebook_url');
            $event->twitter_url = Input::get('twitter_url');
            $event->youtube_url = Input::get('youtube_url');
            $event->recurring = Input::get('recurring');
            $event->dree_code = Input::get('dree_code');
            $event->special_note = Input::get('special_note');
            $event->photo = (implode(',',$images));
            $event->save();
            $resultArray = ['status' => 1, 'message' => 'Event created Successfully!', 'dataArray' => $event];
        }
        return Response::json($resultArray, 200);
    }

    public function updateEvent($id) // 3. This update function will update the event
    {
        $event = $this->event->updateEvent($id);
        if (!$event) {
            $resultArray = ['status' => 0, 'message' => 'Event does not exist!'];
            return Response::json($resultArray, 200);
        }
        $resultArray = ['status' => 1, 'message' => 'Event updated Successfully!', 'dataArray' => $event];
        return Response::json($resultArray, 200);
    }

    public function deleteEvent($id) //4.  This function will delete the event against ids
    {
        $event = $this->event->deleteEvent($id);
        if (!$event) {
            $resultArray = ['status' => 0, 'message' => 'Event does not exist!'];
            return Response::json($resultArray, 200);
        }
        $resultArray = ['status' => 1, 'message' => 'Event removed Successfully!', 'dataArray' => $event];
        return Response::json($resultArray, 200);
    }

    public function addToFavourites(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $favourites = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->count();
        if ($favourites > 0) {
            // already exist in db
            DB::table('event_ratings')
                ->where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->update(['favourites' => 1]);
        } else {
            // does not exist, insert for first time
            $favourites = new EventRating();
            $favourites->user_id = Input::get('user_id');
            $favourites->venue_id = Input::get('venue_id');
            $favourites->event_id = Input::get('event_id');
            $favourites->type = Input::get('type');
            $favourites->favourites = 1;
            $favourites->save();
        }
        $resultArray = ['status' => 1, 'message' => ucfirst($type) . ' added to favourite Successfully!', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

    public function removeFromFavourite(Request $request)
    {
        $user_id  = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type     = $request->input('type');
        $favourites = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->count();
        if ($favourites > 0) {
            // already exist in db

            DB::table('event_ratings')
                ->where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->update(['favourites' => 0]);

            $resultArray = ['status' => 1, 'message' => ucfirst($type) . ' removed from favourite Successfully!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        } else {
            $resultArray = ['status' => 0, 'message' => ucfirst($type) . ' was not added to favourites', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
    }

    public function eventLikeUnlike(Request $request)
    {
        $date = date('Y-m-d');
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $user_lat = $request->input('latitude');
        $user_long = $request->input('longitude');
        if(empty($user_lat) || empty($user_long))
        {
            $resultArray = ['status' => 0, 'message' => 'You missed latitude & longitude!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
        //get venue by id
        $event = DB::table('event')
            ->select(DB::raw(
                '
              event.*,
              IFNULL(
                (
                  (
                    (
                      ACOS(
                        SIN(
                          (
                            '.$user_lat.' * PI() / 180
                          )
                        ) * SIN((venues.`latitude` * PI() / 180)) + COS(
                          (
                            '.$user_lat.' * PI() / 180
                          )
                        ) * COS((venues.`latitude` * PI() / 180)) * COS(
                          (
                            (
                              '.$user_long.' - venues.`longitude`
                            ) * PI() / 180
                          )
                        )
                      )
                    ) * 180 / PI()
                  ) * 60 * 1.1515
                ),
                0
              ) AS `distance_miles` '
            ))
            ->where('event.id', '=', $event_id)
            ->join('venues','venues.id', '=','event.venue_id')
             ->having('distance_miles','<=','0.1')
            ->first();
        if(empty($event)) {
            $resultArray = ['status' => 0, 'message' => 'You must check-in to venue for ripple!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }

        $likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->where('created_at', 'like', '%'.$date.'%')->first();
        $rippled = false;
        if ($likes) {
            if ($likes->likes == 0) {
                DB::table('event_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['likes' => 1]);
                $message = ucfirst($type) . ' rippled!!';
                $rippled = true;
            } else {
                DB::table('event_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['likes' => 0]);
                $message = ucfirst($type) . ' un-rippled!!';
            }
        } else {
            DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->delete();
            $likes = new EventRating();
            $likes->user_id = Input::get('user_id');
            $likes->venue_id = Input::get('venue_id');
            $likes->event_id = Input::get('event_id');
            $likes->type = Input::get('type');
            $likes->likes = 1;
            $likes->save();
            $message = ucfirst($type) . ' rippled!!';
            $rippled = true;;
        }
        if($rippled) {
            $reward = new Reward();
            $reward->getRipplePoint($user_id, 'ripple', 20, 'event', $event_id);
        }
        $resultArray = ['status' => 1, 'message' => $message, 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

    public function likeUnlikeEvent(Request $request)
    {
        $date = date('Y-m-d');
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->first();
        $rippled = false;
        if ($likes) {
            if ($likes->event_likes == 0) {
                DB::table('event_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['event_likes' => 1]);
                $message = ucfirst($type) . ' liked!!';
                $rippled = true;
            } else {
                DB::table('event_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['event_likes' => 0]);
                $message = ucfirst($type) . ' un-liked!!';
            }
        } else {
            DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->delete();
            $likes = new EventRating();
            $likes->user_id = Input::get('user_id');
            $likes->venue_id = Input::get('venue_id');
            $likes->event_id = Input::get('event_id');
            $likes->type = Input::get('type');
            $likes->event_likes = 1;
            $likes->save();
            $message = ucfirst($type) . ' liked!!';
            $rippled = true;
        }
        if($rippled) {
            $reward = new Reward();
            $reward->getRipplePoint($user_id, 'like', 20, 'event', $event_id);
        }
        $resultArray = ['status' => 1, 'message' => $message, 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

    private function getEventsLikes($events, $user_id)
    {
        $tempArray = [];
        $date = date('Y-m-d');
        foreach ($events as $index => $event) {
            $columns = ['likes AS ripple', 'favourites','event_likes AS like'];
            if(isset($event->event_id))
                $event_id = $event->event_id;
            else
                $event_id = $event->id;
            if(!empty($user_id)) {
                $event_likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event->id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
                $likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();

            } else {
                $event_likes = DB::table('event_ratings')->where('event_id', $event->id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
                $likes = DB::table('event_ratings')->where('event_id', $event_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
            }
            $rippleCount = DB::table('event_ratings')->where('event_id', $event_id)->where('likes', 1)->where('created_at', 'like', '%'.$date.'%')->count();
            $likeCount = DB::table('event_ratings')->where('event_id', $event->id)->where('event_likes',1)->where('created_at', 'like', '%'.$date.'%')->count();
            if ($likes) {
                $event->like = $event_likes->like;
                $event->ripple = $likes->ripple;
                $event->favourites = $likes->favourites;
                $event->rippleCount = 0;
                $event->likeCount = 0;
            } else {
                $event->like = 0;
                $event->ripple = 0;
                $event->favourites = 0;
                $event->rippleCount = 0;
                $event->likeCount = 0;
            }
            if ($rippleCount) {
                $event->rippleCount = $rippleCount;
            }
            if($likeCount){
                $event->likeCount = $likeCount;
            }
            $tempArray[$index] = $event;
        }
        return $tempArray;
    }

    public function getEventsFavouriteLists($user_id)
    {
        $eventfavouritelist = DB::table('event')

            ->join('event_ratings', 'event.id', '=', 'event_ratings.event_id')
            ->join('venues','venues.id', '=', 'event.venue_id')
            ->where('event_ratings.user_id', $user_id)
            ->select(['event.*','venues.venue_name', 'venues.venue_address', 'venues.city','venues.state','venues.venue_phone','venues.venue_email','venues.venue_website'])
            ->get();



        $eventfavouritelist = $this->getEventsLikes($eventfavouritelist, $user_id);

        if (!$eventfavouritelist) {
            $eventfavouritelist = ['status' => 0, 'message' => 'Events list does not exist!'];
            return Response::json($eventfavouritelist, 200);


        }
        $eventfavouritelist = ['status' => 1, 'message' => 'Events list appeared Successfully!','dataArray' => $eventfavouritelist];
        return Response::json($eventfavouritelist, 200);
    }
    function radiusQuery($user_lat, $user_long) {
        return 'IFNULL(
                (
                  (
                    (
                      ACOS(
                        SIN(
                          (
                            '.$user_lat.' * PI() / 180
                          )
                        ) * SIN((venues.`latitude` * PI() / 180)) + COS(
                          (
                            '.$user_lat.' * PI() / 180
                          )
                        ) * COS((venues.`latitude` * PI() / 180)) * COS(
                          (
                            (
                              '.$user_long.' - venues.`longitude`
                            ) * PI() / 180
                          )
                        )
                      )
                    ) * 180 / PI()
                  ) * 60 * 1.1515
                ),
                0
              ) AS `distance_miles` ';
    }

}
