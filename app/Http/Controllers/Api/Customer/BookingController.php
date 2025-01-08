<?php

namespace App\Http\Controllers\Api\Customer;
use App\Http\Controllers\Api\BaseController as BaseController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Ride;
use App\Models\Car;
use App\Models\User;
use Auth;

class BookingController extends BaseController
{

    public function journey()
    {
        $data['rides'] = Ride::with('rider')->where('user_id',Auth::user()->id)->where('status','complete')->get();
        return $this->sendResponse($data, 'My Journey Lists');
    }

    public function near_riders_list()
    {
        $longitude = Auth::user()->lng; // Current user's longitude
        $latitude = Auth::user()->lat;  // Current user's latitude
        $radiusInKm = 10;               // Radius to search (in kilometers)
        $role = 'rider';                // Role filter

        // Fetch users within the given radius
        $users = User::select(
            '*',
            \DB::raw("(
                6371 * acos(
                    cos(radians(?))
                    * cos(radians(lat))
                    * cos(radians(lng) - radians(?))
                    + sin(radians(?))
                    * sin(radians(lat))
                )
            ) as distance")
        )
        ->setBindings([$latitude, $longitude, $latitude]) // Bind values for the placeholders
        ->where('role', $role)                            // Filter users by role
        ->having('distance', '<', $radiusInKm)            // Filter by distance
        ->orderBy('distance')                             // Order by nearest distance
        ->get();

        return $this->sendResponse($users, 'Riders List');
    }



    public function car_list()
    {
        $data = Car::where('status','active')->get();
        return $this->sendResponse($data, 'Car Lists');
    }

    public function ride_list(Request $request)
    {
        $today = Carbon::today();
        if($request->type == 'current')
        {
            $data = Ride::whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('status','complete')->where('user_id',Auth::id())->get();
        }
        else
        {
            $data = Ride::whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('status','complete')->where('user_id',Auth::id())->get();
        }
        return $this->sendResponse($data, 'Ride Lists');
    }

    public function ride_update(Request $request,$id)
    {
        $ride = Ride::find($id);
        if($ride)
        {
            $ride->status = $request->status;
            $ride->save();
            $ridee = Ride::with('rider')->find($id);

            return response()->json(['success'=> true,'message'=>'Ride Updated','ride_info'=>$ridee],200);
        }
        else
        {
            return response()->json(['success'=> false,'message'=>'No Ride Found.'],404);
        }
    }

    public function ride_update_time(Request $request,$id)
    {
        $ride = Ride::find($id);
        if($ride)
        {
            $ride->time = $request->time;
            $ride->save();
            $ridee = Ride::with('rider')->find($id);

            return response()->json(['success'=> true,'message'=>'Ride Updated','ride_info'=>$ridee],200);
        }
        else
        {
            return response()->json(['success'=> false,'message'=>'No Ride Found.'],404);
        }
    }
}
