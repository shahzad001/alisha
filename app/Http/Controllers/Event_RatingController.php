<?php

namespace App\Http\Controllers;

use App\EventRating;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class Event_RatingController extends Controller
{
    public function getRating()
    {
        $rating = new EventRating();

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
