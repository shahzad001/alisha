<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VenueRating extends Model
{
    protected $table = 'venue_ratings';
    protected $fillable = ['user_id','venue_id','likes','favourites','event_id','type'];

    // Defining the relations between Venue Ratings table and Event/Venue table

    public function venues()
    {
        return $this->hasMany('App\Venue');
    }
    public function event()
    {
        return $this->belongsToMany('App\Event');
    }
    public function scopePublished($query)
    {
        $query->where('created_at','=', Carbon::now());
    }
}




