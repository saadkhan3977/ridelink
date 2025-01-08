<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\Car;
use App\Models\User;
use Auth;
use App\Notifications\RideStatusNotification;
use App\Services\FirebaseService;
use Validator;

class RideController extends BaseController
{

    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        $longitude = Auth::user()->lng; // Current user's longitude
        $latitude = Auth::user()->lat;  // Current user's latitude
        $radiusInKm = 10;

        $ride = Ride::with('user')->select(
            '*',
            \DB::raw("(
                6371 * acos(
                    cos(radians(?))
                    * cos(radians(pickup_location_lat))
                    * cos(radians(pickup_location_lng) - radians(?))
                    + sin(radians(?))
                    * sin(radians(pickup_location_lat))
                )
            ) as distance")
        )
        ->setBindings([$latitude, $longitude, $latitude]) // Bind values for the placeholders
        ->having('distance', '<', $radiusInKm)            // Filter by distance
        ->orderBy('distance')->where('status','in process')->get();
        return response()->json(['success'=> true,'message'=>'Ride Info','ride_info'=>$ride],200);
    }

    public function rider_ride_update(Request $request,$id)
    {
        $ride = Ride::find($id);
        if($ride)
        {
            if($request->statu == 'request')
            {
                $riderequest = RideRequest::where('ride_id',$id)->where('rider_id',Auth::id())->first();
                if(!$riderequest)
                {
                    return response()->json(['success'=> false,'message'=>'Already Requested!'],500);
                }
                else
                {
                    RideRequest::create(['ride_id' => $id,'rider_id' => Auth::id()]);
                    return response()->json(['success'=> true,'message'=>'Ride Requested Successfull'],200);
                }
            }
            if($request->statu == 'accept')
            {
                $riderequest = RideRequest::where('ride_id',$id)->where('rider_id',Auth::id())->first();
                $ride->status = $request->status;
                $ride->save();
            }

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

    public function update_location(Request $request)
    {

        $user = User::find(Auth::user()->id);
        $user->lat = $request->lat;
        $user->lng = $request->lng;
        $user->save();
        return response()->json(['success'=> true,'message'=>'Location Updated','user_info'=>$user],200);
    }

    public function car_update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'number' => 'required|string',
            'seats' => 'required|string',
            'type' => 'required|string',
            'category' => 'required|string',
            'model' => 'required|string',
            'status' => 'required|string',
    		'image' => 'image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);
        if($validator->fails())
        {
		    return $this->sendError($validator->errors()->first());
        }

        $user = Car::where('user_id',Auth::id())->first();
        $input = $request->except(['token'],$request->all());

        $fileName = null;
        if($request->hasFile('image'))
        {
            $file = request()->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/car/image/', $fileName);
            $profile = asset('uploads/car/image/'.$fileName);
            $input['image'] = '/uploads/car/image/'.$fileName;//$profile;
        }

        $input['user_id'] = Auth::id();
        if($user)
        {
            $user = $user->update($input);
        }
        else
        {
            $user = Car::create($input);
        }
        return response()->json(['success'=> true,'message'=>'Car Update','car_info'=>$user],200);
    }
}
