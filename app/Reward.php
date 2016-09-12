<?php

namespace App;

use App\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class Reward extends Model
{
    protected $table = 'rewards';

    function getRewardPoints($user_id, $callType, $points, $rippletype = '', $id = 0) {

        $fields = [
            'user_id' => $user_id,
            'call_count' => 1,
            'call_type' => $callType,
            'reward_points' => $points,
            'created_at' => Carbon::now()
        ];
        if(!empty($rippletype)) {
            $fields[$rippletype.'_id'] = $id;
        }
        DB::table('rewards')
            ->insert($fields);
    }

    public function getLoginPoint($user_id, $callType, $points)
    {
        $date = date('Y-m-d H:i:s',strtotime("-1 days"));
        $alreadyLoggedIn = DB::table('rewards')
            ->where('user_id', $user_id)
            ->where('call_type', $callType)
            ->where('created_at', '>=', $date)->first();

        if(empty($alreadyLoggedIn))
            $this->getRewardPoints($user_id, $callType, $points);
    }
    public function getEventPoint($user_id, $callType, $points)
    {
        $date = date('Y-m-d H:i:s',strtotime("-1 days"));
        $alreadyEvent = DB::table('rewards')
            ->where('user_id', $user_id)
            ->where('call_type', $callType)
            ->where('created_at', '>=', $date)->first();

        if(empty($alreadyEvent))
            $this->getRewardPoints($user_id,$callType,$points);
    }
    public function getRipplePoint($user_id, $callType,$points, $rippletype,$id){
        $date = date('Y-m-d');
        $alreadyEvent = DB::table('rewards')
            ->where('user_id', $user_id)
            ->where('call_type', $callType)
            ->where($rippletype.'_id', $id)
            ->where('created_at', 'like', '%'.$date.'%')->first();

        if(empty($alreadyEvent))
            $this->getRewardPoints($user_id, $callType, $points, $rippletype,$id);
    }
    public function inviteFriends($user_id,$callType,$points)
    {
        $date = date('Y-m-d H:i:s',strtotime("-7 days"));
        $inviteFriends = DB::table('rewards')
            ->where('user_id', $user_id)
            ->where('call_type', $callType)
            ->where('created_at', '>=', $date)->count();
        if($inviteFriends < 5)
            $this->getRewardPoints($user_id, $callType, $points);
    }
}
