<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ListController extends MyController
{
    public function getFavouriteLists(Request $request)
    {
        $dataArray = [];
        $user_id = (int) $request->input('user_id');

        $events = DB::table('event')
            ->join('event_ratings','event.id', '=', 'event_ratings.event_id')
            ->join('venues','venues.id', '=', 'event.venue_id')
            ->where('event_ratings.user_id', '=', $user_id)
            ->where('event_ratings.favourites', '=', 1)
            ->select(['event.*','event_ratings.event_id','event_ratings.type','event_ratings.venue_id','event.venue_id AS venue_id','venues.venue_name', 'venues.venue_address', 'venues.city','venues.state','venues.venue_phone','venues.venue_email','venues.venue_website','venues.latitude','venues.longitude'])
            ->get();

        $venues = DB::table('venues')
            ->select(['venues.*','venue_ratings.venue_id','venue_ratings.event_id','venue_ratings.type','venue_ratings.venue_id','venues.venue_name', 'venues.venue_address', 'venues.city','venues.state','venues.venue_phone','venues.venue_email','venues.venue_website'])
            ->join('venue_ratings','venue_ratings.venue_id', '=', 'venues.id')
            ->where('venue_ratings.user_id', '=', $user_id)
            ->where('venue_ratings.favourites', '=', 1)
            ->get();

        $message = 'Favourite lists appeared Successfully!';

        if(count($events) > 0)
            $events = $this->getJoinedEventsLikes($events,$user_id);

        if(count($venues) > 0)
            $venues = $this->getJointVenuesLikes($venues,$user_id);

        $dataArray = array_merge($dataArray, $events, $venues);

        $resultArray = ['status' => 1, 'message' => $message, 'dataArray' => $dataArray];
        return Response::json($resultArray, 200);
    }

    public function getUnFavouriteLists(Request $request)
    {
        $user_id = $request->input('user_id');
        $venue_id = $request->input('venue_id');
        $event_id = $request->input('event_id');
        $type = $request->input('type');
        $favourites = DB::table('venue_ratings')->where('user_id',$user_id)->where('venue_id',$venue_id)->count();
        if($favourites > 0) {

            DB::table('venue_ratings')
                ->where('user_id', $user_id)
                ->where('venue_id', $venue_id)
                ->update(['favourites' => 0]);

            $resultArray = ['status' => 1, 'message' => ucfirst($type).' removed from favourite Successfully!', 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
        else {
                $favourites = DB::table('event_ratings')->where('user_id',$user_id)->where('venue_id',$venue_id)->count();

                DB::table('event_ratings')
                ->where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->update(['favourites' => 0]);

            $resultArray = ['status' => 1, 'message' => ucfirst($type) . ' removed from favourite Successfully!', 'favourites' => $favourites, 'dataArray' => []];
            return Response::json($resultArray, 200);
        }
    }
}



