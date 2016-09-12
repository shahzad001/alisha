<?php

namespace App\Http\Controllers;

use App\VenueRating;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class Venue_RatingController extends Controller
{
    public function getRating()
    {
        $rating = new VenueRating();
        $rating->user_id      = Input::get('user_id');
        $rating->venue_id      = Input::get('venue_id');
        $rating->likes      = Input::get('likes');
        $rating->favourites      = Input::get('favourites');
        $rating->type      = Input::get('type');
        $rating->event_id      = Input::get('event_id');
        $rating->save();
        return $rating;

    }
}
