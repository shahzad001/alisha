<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRating extends Model
{
    protected $table = 'event_ratings';

    protected $fillable = ['user_id','venue_id','likes','favourites','type','event_id'];
}
