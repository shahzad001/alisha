<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class assign_remove_staff extends Model
{
    protected $table = 'assign_remove_staff';

    protected $fillable = ['staff_name','venue_name','event_name','staff_role'];

    public static function allStaff()
    {
        return self::all();
    }

    public function assignStaff()
    {
        $input = Input::all();
        $assignStaff = new assign_remove_staff();
        $assignStaff->fill($input);
        $assignStaff->save();
        return $assignStaff;
    }

    public function removeStaff($id)
    {
        DB::table('assign_remove_staff')->where('staff_name', '=', $id)->delete();

    }
}
