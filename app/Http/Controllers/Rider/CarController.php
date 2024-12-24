<?php

namespace App\Http\Controllers\Rider;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Ride;
use App\Models\User;
use Pusher\Pusher;
use App\Events\RideStatus;
use App\Notifications\RideStatusNotification;
use App\Services\FirebaseService;
use Auth;

// use App\Models\Category;
// use App\Models\PostTag;
// use App\Models\Brand;

use Illuminate\Support\Str;

class CarController extends Controller
{

    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars=Car::paginate(10);
        // return $cars;
        return view('rider.car.index')->with('cars',$cars);
    }

    public function car_ride_request()
    {
        $cars= Ride::where('status','pending')->paginate(10);
        // return $cars;
        return view('rider.car.ride-request')->with('rides',$cars);
    }

    public function car_rides()
    {
        $cars= Ride::whereNot('status','pending')->paginate(10);
        // return $cars;
        return view('rider.car.ride-list')->with('rides',$cars);
    }

    public function car_ride_assign_form($id)
    {
        $data['ride'] = Ride::find($id);
        $data['cars'] = Car::get();
        $data['riders'] = User::where('role','rider')->where('assign','no')->get();
        return view('rider.car.ride-assign',$data);
    }

    public function car_ride_assign($id,Request $request)
    {
        $ride =  Ride::find($id);
        $ride->rider_id = $request->rider_id;
        $ride->status = 'in process';
        $ride->save();


        $data = Ride::with('carinfo','rider')->find($id);

        $rider = User::find($request->rider_id); // rider ka user model

        $body = Auth::user()->first_name . ' ' . Auth::user()->last_name .' Assign New Ride Ride';
        $title = request()->text;
        $fcmToken = $rider->device_token;
        $response = $this->firebaseService->sendNotification($fcmToken, $title, $body);

        return redirect('admin/car-ride-new')->with('success' , 'Ride Assign Successfully');
    }

    protected function sendRideNotification(Ride $ride)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );

        $data['message'] = 'Your ride from ' . $ride->location_from . ' to ' . $ride->location_to . ' has been booked!';
        $data['data'] = $ride;
        $pusher->trigger('ride-channel', 'ride-booked', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rider.car.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'string|required',
            'model'=>'required',
            'no'=>'required',
            'seats'=>'required',
            'image'=>'string|required',
            'price'=>'numeric',
            'status'=>'required|in:active,inactive',
        ]);

        $data=$request->all();

        $status=Car::create($data);
        if($status){
            request()->session()->flash('success','Car Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('car.index');

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('rider.car.edit')->with('car',$car);
    }

    public function update(Request $request, $id)
    {
        $car=Car::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required',
            'model'=>'required',
            'no'=>'required',
            'seats'=>'required',
            'image'=>'string|required',
            'price'=>'numeric',
            'status'=>'required|in:active,inactive',
        ]);

        $data=$request->all();

        $status=$car->fill($data)->save();
        if($status)
        {
            request()->session()->flash('success','Car Successfully updated');
        }

        else
        {
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('car.index');
    }

    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();

        if($status)
        {
            request()->session()->flash('success','Product successfully deleted');
        }
        else
        {
            request()->session()->flash('error','Error while deleting product');
        }

        return redirect()->route('product.index');
    }

    public function car_ride_delete($id)
    {
        $ride = Ride::findOrFail($id);
        $status=$ride->delete();

        if($status){
            request()->session()->flash('success','Ride Request successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->back();
    }
}
