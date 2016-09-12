<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Event extends Model
{
    protected $table = 'event';
    protected $fillable = ['user_id','venue_id','event_name','special_note','title','description','event_type','dree_code','music_type','price','date_from','date_to','time_from','time_to','age_restriction','parking','phone','facebook_url','twitter_url','youtube_url','recurring'];

    public static function allEvent(){
        return self::all();
    }
    public function registerEvent()
    {
        $input = Input::all();
        $event = new Event();
        $event->fill($input);
        $event->save();
        return $event;
    }
    public function getEvent($id)
    {
        $event = self::find($id);
        if(is_null($event))
        {
            return false;
        }
        return $event;
    }
    public function updateEvent($id)
    {
        $event = self::find($id);
        if (is_null($event)) {
            return false;
        }
        $input = Input::all();
        $event->fill($input);
        $event->save();
        return $event;
    }
    public function deleteEvent($id)
    {
        $event = self::find($id);
        if(is_null($event))
        {
            return false;
        }
        return $event->delete();
    }
    public function rating()
    {
        return $this->hasMany('App\VenueRating');
    }
    /*public function setDateFromAttribute($date)
    {
        $this->attributes['date_from'] = Carbon::parse($date)->format('Y-m-d');
    }
    public function setDateToAttribute($date)
    {
        $this->attributes['date_to'] = Carbon::parse($date)->format('Y-m-d');
    }

    public function getDateFromAtAttribute($date)
    {
        return Carbon::parse($date)->format('d M Y');
    }
    public function getDateToAtAttribute($date)
    {
        return Carbon::parse($date)->format('d M Y');
    }*/
}

