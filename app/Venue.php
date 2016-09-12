<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class Venue extends Model
{
    protected $table = 'venues';
    protected $fillable = ['venue_name','description','venue_address','special_note','city','days_closed','time_from','time_to', 'state', 'postal_code', 'venue_phone', 'venue_website', 'venue_email','photo','user_id'];


    public static function allVenue()
    {
        return self::all();
    }

    public function registerVenue()
    {
        $input = Input::all();
        $venue = new Venue();
        $venue->fill($input);
        $venue->save();
        return $venue;
    }

    public function getVenue($id)
    {
        $venue = self::find($id);
        if (is_null($venue)) {
            return false;
        }
        return $venue;
    }

    public function updateVenue($id)
    {
        $venue = self::find($id);
        if (is_null($venue)) {
            return false;
        }
        $input = Input::all();
        $venue->fill($input);
        $venue->save();
        return $venue;
    }
    public function deleteVenue($id)
    {
        $venue = self::find($id);
        if(is_null($venue))
        {
            return false;
        }
        return $venue->delete();
    }

    // Defining the relation between Venue model and user

    public function user(){

        return $this->belongsTo('App\User');
    }
    // Defining the relation between Venue model and VenueRating
    public function rating()
    {
        return $this->belongsToMany('App\VenueRating')->withTimestamps();
    }
}
