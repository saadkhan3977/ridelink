<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use Auth;
use App\Notifications\RideStatusNotification;
use App\Services\FirebaseService;

class RideController extends Controller
{

    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        $ride = Ride::with('carinfo','user')->where('status','in process')->where('rider_id',Auth::user()->id)->first();
        return response()->json(['success'=> true,'message'=>'Ride Info','ride_info'=>$ride],200);
    }

    public function rider_ride_update(Request $request,$id)
    {
        $ride = Ride::find($id);
        if($ride)
        {
            $ride->status = 'accept';
            $ride->save();

            $user = User::find(Auth::user()->id);
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->save();

            $customer = User::find($ride->user_id); // user ka user model

            // $body = Auth::user()->first_name . ' ' . Auth::user()->last_name .' Accept Your Ride Request';
            // $title = request()->text;
            // $fcmToken = $customer->device_token;
            // $response = $this->firebaseService->sendNotification($fcmToken, $title, $body);
            $ridee = Ride::with('rider')->find($id);

            return response()->json(['success'=> true,'message'=>'Ride Accepted','ride_info'=>$ridee],200);
        }
        else
        {
            return response()->json(['success'=> false,'message'=>'No Ride Found.'],404);
        }
    }
}
