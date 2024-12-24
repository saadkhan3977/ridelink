<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\User;
use Auth;
use App\Notifications\RideStatusNotification;
use App\Services\FirebaseService;
use Validator;

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

    public function car_update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'car_name' => 'required|string',
            'car_number' => 'required|string',
            'car_seats' => 'required|string',
            'car_category' => 'required|string',
            'car_image' => 'required|string',
    		'car_model' => 'image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);
        if($validator->fails())
        {
		    return $this->sendError($validator->errors()->first());
        }

        $user = User::find(Auth::id());
        $fileName = null;
        if($request->hasFile('car_image'))
        {
            $file = request()->file('car_image');
            $fileName = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/user/car_image/', $fileName);
            $profile = asset('uploads/user/car_image/'.$fileName);
        }

        $input = $request->except(['token'],$request->all());

        $input['photo'] = '/uploads/user/car_image/'.$fileName;//$profile;
	    $user = $user->update($input);
        return response()->json(['success'=> true,'message'=>'Car Update','user_info'=>$user],200);
    }
}
