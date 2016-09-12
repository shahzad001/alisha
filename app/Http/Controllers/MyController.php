<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use App\Venue;
use App\VenueRating;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\MyLib\Gcm;

class MyController extends Controller
{

    protected $venue = null;
    public function __construct(Venue $venue)
    {

        $this->venue = $venue;
    }

    /**
     * This function has data fetched from VENUES table only
     *
     * @param $venues
     * @param $user_id
     * @return array
     */
    protected function getVenuesLikes($venues, $user_id){

        $tempArray = [];
        $date = date('Y-m-d');
        foreach ($venues as $index => $venue) {
            $columns = ['likes AS ripple','favourites','venue_likes AS like'];
            $venue_likes = DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id', '=', $venue->id)->select($columns)->first();
            $likes = DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id','=', $venue->id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
            $favourite = DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id','=', $venue->id)->select($columns)->first();
            $eventCount = DB::table('event')->where('venue_id', '=',$venue->id)->count();
            $rippleCount = DB::table('venue_ratings')->where('venue_id', '=',$venue->id)->where('likes','=',1)->where('created_at', 'like', '%'.$date.'%')->count();
            $likeCount = DB::table('venue_ratings')->where('venue_id', '=',$venue->id)->where('venue_likes','=',1)->count();
            if($likes) {
                $venue->like = $venue_likes->like;
                $venue->ripple = $likes->ripple;
                $venue->favourites = (empty($favourite))?0:$favourite->favourites;
                $venue->eventCount = 0;
                $venue->rippleCount = 0;
                $venue->likeCount = 0;
            } else {
                $venue->like = 0;
                $venue->ripple = 0;
                $venue->favourites = 0;
                $venue->eventCount = 0;
                $venue->rippleCount = 0;
                $venue->likeCount = 0;
            }

            if($eventCount) {
                $venue->eventCount = $eventCount;
            }
            if($rippleCount){
                $venue->rippleCount = $rippleCount;
            }
            if($likeCount){
                $venue->likeCount = $likeCount;
            }

            if($favourite) {
                $venue->favourites = $favourite->favourites;
            }

            $tempArray[$index] = $venue;
        }
        return $tempArray;
    }

    /**
     * This function has data fetched from VENUE & VENUE Rating table
     *
     * @param $venues
     * @param $user_id
     * @return array
     */


    protected function getJointVenuesLikes($venues, $user_id){

        $tempArray = [];
        $date = date('Y-m-d');
        foreach ($venues as $index => $venue) {
            $columns = ['likes AS ripple','favourites','venue_likes AS like'];
            $venue_likes = DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id', $venue->venue_id)->select($columns)->first();
            $likes = DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id', $venue->venue_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
            $favourite = DB::table('venue_ratings')->where('user_id', $user_id)->where('venue_id', $venue->venue_id)->select($columns)->first();
            $eventCount = DB::table('event')->where('venue_id', $venue->venue_id)->count();
            $rippleCount = DB::table('venue_ratings')->where('venue_id', $venue->venue_id)->where('likes',1)->where('created_at', 'like', '%'.$date.'%')->count();
            $likeCount = DB::table('venue_ratings')->where('venue_id', $venue->venue_id)->where('venue_likes',1)->count();
            if($likes) {
                $venue->like = $venue_likes->like;
                $venue->ripple = $likes->ripple;
                $venue->favourites = (empty($favourite))?0:$favourite->favourites;
                $venue->eventCount = 0;
                $venue->rippleCount = 0;
                $venue->likeCount = 0;

            } else {
                $venue->like = 0;
                $venue->ripple = 0;
                $venue->favourites = 0;
                $venue->eventCount = 0;
                $venue->rippleCount = 0;
                $venue->likeCount = 0;
            }

            if($eventCount) {
                $venue->eventCount = $eventCount;
            }
            if($rippleCount){
                $venue->rippleCount = $rippleCount;
            }
            if($likeCount){
                $venue->likeCount = $likeCount;
            }

            if($favourite) {
                $venue->favourites = $favourite->favourites;
            }

            $tempArray[$index] = $venue;
        }
        return $tempArray;
    }

    /**
     * this functtion is used by data fetche from EVENTS table only
     *
     * @param $events
     * @param null $user_id
     * @return array
     */
    protected function  getEventsLikes($events, $user_id = null)
    {
        $tempArray = [];
        $date = date('Y-m-d');
        foreach ($events as $index => $event) {
            $columns = ['likes AS ripple', 'favourites','event_likes AS like'];
            if(isset($event->event_id))
                $event_id = $event->event_id;
            else
                $event_id = $event->id;
            if(!empty($user_id)) {
                $event_likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event->id)->select($columns)->first();
                $likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
                $favourite = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event_id)->select($columns)->first();

            } else {
                $event_likes = DB::table('event_ratings')->where('event_id', $event->id)->select($columns)->first();
                $likes = DB::table('event_ratings')->where('event_id', $event_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
                $favourite = DB::table('event_ratings')->where('event_id', $event_id)->select($columns)->first();
            }
            $rippleCount = DB::table('event_ratings')->where('event_id', $event_id)->where('likes', 1)->where('created_at', 'like', '%'.$date.'%')->count();
            $likeCount = DB::table('event_ratings')->where('event_id', $event->id)->where('event_likes',1)->count();

            if ($likes) {
                $event->like = (empty($event_likes))?0:$event_likes->like;
                $event->ripple = $likes->ripple;
                $event->favourites = (empty($favourite))?0:$favourite->favourites;
                $event->rippleCount = 0;
                $event->likeCount = 0;

            } else {
                $event->like = 0;
                $event->ripple = 0;
                $event->favourites = 0;
                $event->rippleCount = 0;
                $event->likeCount = 0;
            }
            if ($rippleCount) {
                $event->rippleCount = $rippleCount;
            }
            if($likeCount){
                $event->likeCount = $likeCount;
            }

            if($favourite) {
                $event->favourites = $favourite->favourites;
            }
            $tempArray[$index] = $event;
        }
        return $tempArray;
    }

    /**
     * this function is used data fetched by EVENTS & its RATING table JOIN
     *
     * @param $events
     * @param null $user_id
     * @return array
     */
    protected function getJoinedEventsLikes($events, $user_id = null)
    {
        $tempArray = [];
        $date = date('Y-m-d');
        foreach ($events as $index => $event) {
            $columns = ['likes AS ripple', 'favourites','event_likes AS like'];
            if(!empty($user_id)) {
                $event_likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', $event->event_id)->select($columns)->first();
                $likes = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', '=', $event->event_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
                $favourite = DB::table('event_ratings')->where('user_id', $user_id)->where('event_id', '=', $event->event_id)->select($columns)->first();
            } else {
                $event_likes = DB::table('event_ratings')->where('event_id', $event->event_id)->select($columns)->first();
                $likes = DB::table('event_ratings')->where('event_id', '=', $event->event_id)->where('created_at', 'like', '%'.$date.'%')->select($columns)->first();
                $favourite = DB::table('event_ratings')->where('event_id', '=', $event->event_id)->select($columns)->first();
            }
            $rippleCount = DB::table('event_ratings')->where('event_id', $event->event_id)->where('likes', 1)->where('created_at', 'like', '%'.$date.'%')->count();
            $likeCount = DB::table('event_ratings')->where('event_id',  '=',$event->event_id)->where('event_likes', '=',1)->count();
            if ($likes) {
                $event->like = $event_likes->like;
                $event->ripple = $likes->ripple;
                $event->favourites = (empty($favourite))?0:$favourite->favourites;
                $event->rippleCount = 0;
                $event->likeCount = 0;
            } else {
                $event->like = 0;
                $event->ripple = 0;
                $event->favourites = 0;
                $event->rippleCount = 0;
                $event->likeCount = 0;
            }
            if ($rippleCount) {
                $event->rippleCount = $rippleCount;
            }
            if($likeCount) {
                $event->likeCount = $likeCount;
            }
            if($favourite) {
                $event->favourites = $favourite->favourites;
            }
            $tempArray[$index] = $event;
        }
        return $tempArray;
    }

    function radiusQuery($user_lat, $user_long) {
        return 'IFNULL(
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
              ) AS `distance_miles` ';
    }
    public function sendPushNotification($message, $to, $device_type, $code = 1, $type='General') {
        $gcm = new Gcm();
        $gcm->setMessage($message);
        $gcm->addRecepient($to->device_id);
        $gcm->setData(array(
            'message' => $message,
            'Status' => 1,
            'alertType' => $type
        ));
        $gcm->send();
        return [$gcm->status, $gcm->messagesStatuses];
    }


    /*function sendPushNotification($message, $to, $device_type, $code = 1, $type='General'){

        try {
            $nickname=$to->first_name;
            $gcmId=$to->device_id;
            if($device_type=="iphone"){
                $deviceToken =$gcmId;
                // Put your private key's passphrase here:
                $passphrase = '';

                // Put your alert message here:
                $data =json_encode(array('name'=>$nickname,"type"=>$type,'code'=>$code));
                ////////////////////////////////////////////////////////////////////////////////
                //debug($data);exit;
                //debug($deviceToken);exit;
                $ctx = stream_context_create();
                stream_context_set_option($ctx, 'ssl', 'local_cert', WWW_ROOT.'Certificates-develpmnt.p12.pem');
                stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                // Open a connection to the APNS server
                $fp = stream_socket_client(
                //'ssl://gateway.push.apple.com:2195', $err,
                    'ssl://gateway.sandbox.push.apple.com:2195', $err,
                    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);


                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);

                'Connected to APNS' . PHP_EOL;

                // Create the payload body
                $body['aps'] = array(
                    'alert' => $message,
                    'sound' => 'default'
                );

                $body['data'] = array(
                    'alert' => $data,
                    'sound' => 'default'
                );
                // Encode the payload as JSON
                $payload = json_encode($body);

                // Build the binary notification
                @$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));
                //debug($result);exit;
                //echo $result;exit;
                if (!$result)
                    'Message not delivered' . PHP_EOL;
                else
                    'Message successfully delivered' . PHP_EOL;

                // Close the connection to the server
                fclose($fp);
            }else{
                $GOOGLE_API_KEY ='AIzaSyCOv9AjpeZu2RZdK33fkONjTbwfkoNeMoA';
                $url = 'https://android.googleapis.com/gcm/send';
                $registration_ids=$gcmId;
                $encodeMessage=json_encode(array("message"=>$message,"type"=>$type));
                $registration_ids = array($registration_ids);
                $fields = array(
                    'data'              => array( "aps" =>$encodeMessage ),
                );

                $headers = array(
                    'Authorization: key=' . $GOOGLE_API_KEY,
                    'Content-Type: application/json'
                );

                // Open connection
                $ch = curl_init();

                // Set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Disabling SSL Certificate support temporarly
                //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                // Execute post
                $result = curl_exec($ch);
                if ($result === FALSE){
                    die('Curl failed: ' . curl_error($ch));
                }
                // Close connection
                curl_close($ch);
            }
            return true;

        }catch(PDOException $e){
            throw  $e;
        }
    }*/
}
