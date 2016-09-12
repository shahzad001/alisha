<?php

namespace App\Http\Controllers;

use App\Event;
use App\Image;
use App\Reward;
use App\User;
use App\Venue;
use App\VenueRating;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class VenuesController extends MyController
{

    protected $venue = null;
    public function __construct (Venue $venue)
    {
        $this->venue = $venue;
    }
    public function allVenues() //1.  This function  will return all venues from db
    {
        return Response::json($this->venue->allVenue(), 200);
    }

    public function getVenue($id)//2.  This function will return venue against id
    {
        // get user type:
        $user_type = User::findOrFail($id)->user_type;

        $user_lat = Input::get('latitude');
        $user_long = Input::get('longitude');
        $user_radius = Input::get('user_radius');
        if(empty($user_radius))
            $user_radius = 100;

        if($user_type == 'user') {
            if(empty($user_lat) || empty($user_long)) {
                $venue = DB::table('venues')
                    ->get();
            } else {

                $venue = DB::table('venues')
                    ->select(DB::raw(
                        '*,' . $this->radiusQuery($user_lat, $user_long)
                    ))
                    ->having('distance_miles', '<=', $user_radius)
                    ->get();
            }
        } else if($user_type == 'staff'){
            if(empty($user_lat) || empty($user_long)) {
                $venue = DB::table('users')
                    ->join('assign_remove_staff', 'users.email_address', '=', 'assign_remove_staff.staff_name')
                    ->join('venues', 'assign_remove_staff.venue_name', '=', 'venues.venue_name')
                    ->groupBy('venues.venue_name')
                    ->where('users.id', $id)
                    ->get();
            } else {
                $venue = DB::table('users')
                    ->join('assign_remove_staff', 'users.email_address', '=', 'assign_remove_staff.staff_name')
                    ->join('venues', 'assign_remove_staff.venue_name', '=', 'venues.venue_name')
                    ->groupBy('venues.venue_name')
                    ->select(DB::raw(
                        '*,' . $this->radiusQuery($user_lat, $user_long)
                    ))
                    ->having('distance_miles', '<=', $user_radius)
                    ->where('users.id', $id)
                    ->get();
            }
        } else {
            if(empty($user_lat) || empty($user_long)) {
                $venue = DB::table('venues')
                    ->where('user_id', $id)->get();
            } else {
                $venue = DB::table('venues')
                    ->select(DB::raw(
                        '*,'.$this->radiusQuery($user_lat, $user_long)
                    ))
                    ->having('distance_miles','<=',$user_radius)
                    ->where('user_id', $id)->get();
            }
        }
        if(!$venue)
        {
            $resultArray = ['status' => 0, 'message' => 'List not found!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
        else{
            $venue = $this->getVenuesLikes($venue, $id);
            $resultArray = ['status' => 1, 'message' => 'Venues list appeared Successfully!', 'dataArray' => $venue];
            return Response::json($resultArray, 200);
        }
    }
    public function registerVenue(Request $request) //3.  This function will registered new venues
    {
        $fieldsValidation = [

            'venue_name'    => 'required',
            'venue_address' => 'required',
            'description'   => 'required',
            'city'          => 'required',
            'state'         => 'required',
            'postal_code'   => 'required',
            'venue_phone'   => 'required',
            'venue_website' => 'required',
            'venue_email'   => 'required',
            'time_from'     => 'required',
            'time_to'       => 'required',
            'days_closed'   => 'required',
            'longitude'     => 'required',
            'latitude'      => 'required',
        ];
        $validator = Validator::make($request->all(), $fieldsValidation);

        if ($validator->fails()) {
            $resultArray = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'dataArray' => []
            ];
        } else {
            $images = [];
            if ($request->hasFile('photo'))
            {
                $files = \Illuminate\Support\Facades\Request::file('photo');
                $image_path = public_path().'/images/';
                $images = [];
                foreach($files as $file){
                    $image_name = 'venue_'.Carbon::now()->toDateString().rand().'.'.$file->getClientOriginalExtension();
                    $file->move($image_path,$image_name);
                    $images[]=$image_name;
                }
            }
            $isAlreadyExist = DB::table('venues')
                ->where('venue_name', Input::get('venue_name'))->count();

            if($isAlreadyExist > 0) {
                $resultArray = ['status' => 1, 'message' => 'You cannot create same venue with same name', 'dataArray' => []];
                return Response::json($resultArray, 200);
            }
            $venue = new Venue();
            $venue->venue_name      = Input::get('venue_name');
            $venue->user_id         = Input::get('user_id');
            $venue->venue_address   = Input::get('venue_address');
            $venue->description     = Input::get('description');
            $venue->city            = Input::get('city');
            $venue->state           = Input::get('state');
            $venue->postal_code     = Input::get('postal_code');
            $venue->venue_phone     = Input::get('venue_phone');
            $venue->venue_website   = Input::get('venue_website');
            $venue->venue_email     = Input::get('venue_email');
            $venue->time_from       = Input::get('time_from');
            $venue->time_to         = Input::get('time_to');
            $venue->days_closed     = Input::get('days_closed');
            $venue->special_note     = Input::get('special_note');
            $venue->longitude       = Input::get('longitude');
            $venue->latitude        = Input::get('latitude');
            $venue->photo           = (implode(',',$images));
            $venue->save();

            $resultArray = ['status' => 1, 'message' => 'Venue created Successfully!', 'dataArray' => $venue];
        }
        return Response::json($resultArray, 200);

    }
    public function updateVenue($id) //4.  This update function will edit and update the venues against id
    {
        $venue = $this->venue->updateVenue($id);
        if(!$venue)
        {
            $resultArray = ['status' => 0, 'message' => 'Venue does not exist!'];
            return Response::json( $resultArray, 400);
        }
        $resultArray = ['status' => 1, 'message' => 'Venue updated Successfully!', 'dataArray' => $venue];
        return Response::json($resultArray, 200);
    }
    public function deleteVenue($id) //5.  From this function we can delete the existing record of venue against ids
    {
        $venue = $this->venue->deleteVenue($id);
        if(!$venue)
        {
            $resultArray = ['status' => 0, 'message' => 'Venue does not exist!'];
            return Response::json( $resultArray, 400);
        }
        $resultArray = ['status' => 1, 'message' => 'Venue removed Successfully!', 'dataArray' => $venue];
        return Response::json($resultArray, 200);
    }

    public function addToFavourite(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $favourites = DB::table('venue_ratings')->where('user_id',$user_id)->where('venue_id',$venue_id)->count();
        if($favourites > 0) {
            // already exist in db
            DB::table('venue_ratings')
                ->where('user_id', $user_id)
                ->where('venue_id', $venue_id)
                ->update(['favourites' => 1]);
        } else {
            // does not exist, insert for first time
            $favourites = new VenueRating();
            $favourites->user_id       = Input::get('user_id');
            $favourites->venue_id      = Input::get('venue_id');
            $favourites->event_id      = Input::get('event_id');
            $favourites->type          = Input::get('type');
            $favourites->favourites      = 1;
            $favourites->save();
        }
        $resultArray = ['status' => 1, 'message' => ucfirst($type).' added to favourite Successfully!', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

    public function removeFromFavourite(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $favourites = DB::table('venue_ratings')->where('user_id',$user_id)->where('venue_id',$venue_id)->count();
        if($favourites > 0) {

            // already exist in db
            DB::table('venue_ratings')
                ->where('user_id', $user_id)
                ->where('venue_id', $venue_id)
                ->update(['favourites' => 0]);

            $resultArray = ['status' => 1, 'message' => ucfirst($type).' removed from favourite Successfully!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        } else {
            $resultArray = ['status' => 0, 'message' => ucfirst($type).' was not added to favourites', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
    }

    /**
     * ripple function
     * @param Request $request
     * @return mixed
     */
    public function likeUnlike(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $user_lat = $request->input('latitude');
        $user_long = $request->input('longitude');
        if(empty($user_lat) || empty($user_long))
        {
            $resultArray = ['status' => 0, 'message' => 'You missed latitude & longitude!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }

        //get venue by id
        $venue = DB::table('venues')
        ->select(DB::raw(
            '
              *,
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
        ->where('id', '=', $venue_id)
        ->having('distance_miles','<=','0.1')
        ->first();

        if(empty($venue)) {
            $resultArray = ['status' => 0, 'message' => 'You must check-in to venue for ripple!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }

        $type = $request->input('type');
        $date = date('Y-m-d');
        $rippled = false;
        $likes = DB::table('venue_ratings')->where('user_id',$user_id)->where('venue_id',$venue_id)->where('created_at', 'like', '%'.$date.'%')->first();
        if($likes) {
            if ($likes->likes == 0) {
                DB::table('venue_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['likes' => 1]);
                $message = ucfirst($type).' rippled!!';
                $rippled  = true;
            } else {
                DB::table('venue_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['likes' => 0]);
                $message = ucfirst($type).' un-rippled!!';
            }
        } else {
            DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id', $venue_id)->delete();
            $likes = new VenueRating();
            $likes->user_id       = Input::get('user_id');
            $likes->venue_id      = Input::get('venue_id');
            $likes->event_id      = Input::get('event_id');
            $likes->type          = Input::get('type');
            $likes->likes         = 1;
            $likes->save();
            $message = ucfirst($type).' rippled!!';
            $rippled  = true;
        };
        if($rippled) {
            $reward = new Reward();
            $reward->getRipplePoint($user_id, 'ripple', 20, 'venue', $venue_id);
        }

        $resultArray = ['status' => 1, 'message' => $message, 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

    /**
     * like function
     * @param Request $request
     * @return mixed
     */
    public function likeUnlikeVenue(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $date = date('Y-m-d');
        $rippled = false;
        $likes = DB::table('venue_ratings')->where('user_id',$user_id)->where('venue_id',$venue_id)->first();
        if($likes) {
            if ($likes->venue_likes == 0) {
                DB::table('venue_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['venue_likes' => 1]);
                $message = ucfirst($type).' liked!!';
                $rippled  = true;
            } else {
                DB::table('venue_ratings')
                    ->where('user_id', $user_id)
                    ->where('venue_id', $venue_id)
                    ->where('event_id', $event_id)
                    ->where('type', $type)
                    ->update(['venue_likes' => 0]);
                $message = ucfirst($type).' un-liked!!';
            }
        } else {
            DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id', $venue_id)->delete();
            $likes = new VenueRating();
            $likes->user_id       = Input::get('user_id');
            $likes->venue_id      = Input::get('venue_id');
            $likes->event_id      = Input::get('event_id');
            $likes->type          = Input::get('type');
            $likes->venue_likes         = 1;
            $likes->save();
            $message = ucfirst($type).' liked!!';
            $rippled  = true;
        };
        if($rippled) {
            $reward = new Reward();
            $reward->getRipplePoint($user_id, 'like', 20, 'venue', $venue_id);
        }

        $resultArray = ['status' => 1, 'message' => $message, 'dataArray' => []];
        return Response::json($resultArray, 200);
    }
    public function getFavouriteLists($user_id)
    {

         $favouritelist = DB::table('venues')
             ->select(['venues.*'])
            ->join('venue_ratings','venues.id', '=', 'venue_ratings.venue_id')->where('venue_ratings.user_id', $user_id)
             ->get();

        $favouritelist = $this->getVenuesLikes($favouritelist,$user_id);

        $resultArray = ['status' => 1, 'message' => 'Favourite lists appeared Successfully!', 'dataArray' => $favouritelist];
        return Response::json($resultArray, 200);

    }
    public function getEventsLists(Request $request, $venue_id)
    {
        $user_id = $request->input('user_id');
        $event = DB::table('event')
            ->join('venues','venues.id', '=', 'event.venue_id')
            ->select(['event.*','venues.venue_name', 'venues.venue_address','venues.latitude','venues.longitude', 'venues.city','venues.state','venues.venue_phone','venues.venue_email','venues.venue_website'])
            ->where('venue_id', $venue_id)
            ->get();

        $event = $this->getEventsLikes($event, $user_id);
        $reward = new Reward();
        $reward->getEventPoint($user_id, 'event', 5);
        $resultArray = ['status' => 1, 'message' => 'Events lists appeared Successfully!', 'dataArray' => $event ];
        return Response::json($resultArray, 200);
    }

    public function calendarCount(Request $request)
    {
        $city = $request->input('city');
        $venue_id = $request->input('venue_id');
        $month_year =   $request->input('month_year');
        $start_date =  Carbon::parse($month_year)->format('M Y');
        $end_date =  Carbon::parse($month_year)->format('M Y');

        $list = DB::table('venues')

            ->join('event','event.venue_id', '=', 'venues.id')
            ->select(DB::raw('COUNT(*) as eventCount, venues.venue_name, event.date_from'))
            ->where('event.date_from', 'like', '%'.$start_date.'%' )
            ->where('event.date_from', 'like', '%'.$end_date.'%' )
            ->where('venues.id', '=', $venue_id)
            ->where('venues.city', 'like','%'.$city.'%')
            ->groupBy('event.date_from')
            ->get();

        $resultArray = ['status' => 1, 'message' => 'List Count', 'dataArray' => $list ];
        return Response::json($resultArray, 200);
    }

    public function eventsByDate(Request $request)
    {
        $venue_id = $request->input('venue_id');
        $date =   $request->input('date');
        $date =  Carbon::parse($date)->format('d M Y');
        $user_id =  $request->input('user_id');

        $list = DB::table('venues')
            ->join('event','event.venue_id', '=', 'venues.id')
            ->select(
                '*',
                'event.id AS event_id'
            )
            ->where('event.date_from', 'like', '%'.$date.'%' )
            ->where('venues.id', '=', $venue_id)
            ->get();
        $list = $this->getEventsLikes($list, $user_id);
        $resultArray = ['status' => 1, 'message' => 'List Count', 'dataArray' => $list ];
        return Response::json($resultArray, 200);
    }

    public function uploadImages(Request $request)
    {
        $images = [];
        if ($request->hasFile('images'))
        {
            $files = \Illuminate\Support\Facades\Request::file('images');
            $image_path = public_path().'/images/';
            $images = [];
            $type = Input::get('type');

            foreach($files as $file){
                $image_name = $type.'_'.Carbon::now()->toDateString().rand().'.'.$file->getClientOriginalExtension();
                $file->move($image_path,$image_name);
                $images[]=$image_name;
                $venue = new Image();
                $venue->user_id      = Input::get('user_id');
                $venue->venue_id     = Input::get('venue_id');
                $venue->event_id     = Input::get('event_id');
                $venue->type         = Input::get('type');
                $venue->images        = ($image_name);
                $venue->save();
            }
        }
        $resultArray = ['status' => 1, 'message' => 'Images uploaded Successfully!', 'dataArray' => $images];
        return Response::json($resultArray, 200);
    }

    public function getImagesLists(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $images = DB::table('images')
            ->where($type.'_id', $id)
            ->where('type', $type)
            ->get();
        if($images)
            $resultArray = ['status' => 1, 'message' => 'Images Lists appeared Successfully!', 'dataArray' => $images];
        else
            $resultArray = ['status' => 0, 'message' => 'Images lists does not exist.', 'dataArray' => []];
        return Response::json($resultArray, 200);
    }

    public function likeUnlikePhoto()
    {

    }
}
