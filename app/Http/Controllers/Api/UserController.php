<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Wallet;
use App\Models\Reason;
use App\Models\Notification;
use Image;
use File;
use Auth;
use Validator;
class UserController extends BaseController
{
	public function __construct()
    {
		$stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function reason_list(Request $request)
	{
		try
		{
			$reasons = Reason::get();
			return response()->json(['success'=>true,'message'=>'Reason Lists','reson_list'=>$reasons]);

		}
		catch(\Exception $e)
		{
			return $this->sendError($e->getMessage());
		}
	}

	public function un_reead_notification()
	{
		$notification = Auth::user()->unreadNotifications;
		$notificationold = Auth::user()->readNotifications;
		$unread = count(Auth::user()->unreadNotifications);
		$read = count(Auth::user()->readNotifications);
		// return $notification[0]->data['title'];
		$data = null;
		if($notification)
		{
			foreach($notification as $row)
			{
				$data[] = [
					'id' => $row->id,
					'title' => $row->data,
					'status' => 'unread'
				];
			}
		}

		$olddata = null;
		if($notificationold){

			foreach($notificationold as $row)
			{
				$data[] = [
					'id' => $row->id,
					'title' => $row->data['title'],
					'description' => $row->data['description'],
					'read_at' => $row->data['time'],
					'status' => 'read'
				];
			}
		}

		return response()->json(['success'=>true,'unread'=> $unread,'read'=> $read,'notification' => $data]);
	}

	public function wallet()
	{
		try
		{
			$wallet = Wallet::where('user_id',Auth::user()->id)->first();
			return response()->json(['success'=>true,'message'=> 'My Wallet','wallet' => $wallet],200);
		}
		catch(\Eception $e)
		{
			return response()->json(['error'=>$e->getMessage()]);
	   	}
	}

	public function read_notification(Request $request)
	{
		try{
			$validator = Validator::make($request->all(),[
				'notification_id' => 'required',
			]);
			if($validator->fails())
			{

				return response()->json(['success'=>false,'message'=> $validator->errors()->first()]);
			}

			$notification= Notification::find($request->notification_id);
			if($notification){
				$notification->read_at = date(now());
				$notification->save();
				$status= $notification;
				if($status)
				{
					return response()->json(['success'=>true,'message'=> 'Notification successfully deleted']);
				}
				else
				{
					return response()->json(['success'=>false,'message'=> 'Error please try again']);
				}
			}
			else
			{
				return response()->json(['success'=>false,'message'=> 'Notification not found']);
			}
		}
		catch(\Eception $e)
		{
			return response()->json(['error'=>$e->getMessage()]);
	   	}
	}

	public function review(Request $request)
	{
		try
		{
			$validator = Validator::make($request->all(),[
				'ride_id' =>'required|exists:rides',
				'rating' =>'required',
				'text' =>'string',
			]);
			if($validator->fails())
			{
				return $this->sendError($validator->errors()->first(),500);
			}

			$review = Review::create([
				'ride_id' => $request->ride_id,
				'user_id' => Auth::user()->id,
				'rating' => $request->rating,
				'text' => $request->text,
			]);

			return response()->json(['success'=>true,'message'=>'Review Created Successfully','review'=>$review]);

		}
		catch(\Exception $e)
		{
			return $this->sendError($e->getMessage());
		}
	}

    public function profile(Request $request)
    {
        try
        {
			$olduser = User::where('id',Auth::user()->id)->first();
			$validator = Validator::make($request->all(),[
				'name' =>'string',
				'phone' => 'string',
				'photo' => 'image|mimes:jpeg,png,jpg,bmp,gif,svg',
			]);
			if($validator->fails())
			{
				return $this->sendError($validator->errors()->first());

			}
			$profile = $olduser->photo;

			if($request->hasFile('photo'))
			{
				$file = request()->file('photo');
				$fileName = md5($file->getClientOriginalName() . time()) . "Ride-link." . $file->getClientOriginalExtension();
				$file->move('uploads/user/profiles/', $fileName);
				$profile = 'uploads/user/profiles/'.$fileName;
			}

			$olduser->name = $request->name;
			$olduser->phone = $request->phone;
			$olduser->photo = $profile;
			$olduser->save();

			$user = User::find(Auth::user()->id);

			return response()->json(['success'=>true,'message'=>'Profile Updated Successfully','user_info'=>$user]);
		}
		catch(\Eception $e)
		{
			return $this->sendError($e->getMessage());
		}

    }
	public function current_plan(Request $request)
	{
		try{
		//$user= User::findOrFail(Auth::id());
		$user = User::with(['child','goal','temporary_wallet','wallet','payments'])->where('id',Auth::user()->id)->first();

		$amount = 100;
		$charge = \Stripe\Charge::create([
			'amount' => $amount,
			'currency' => 'usd',
			'customer' => $user->stripe_id,
		]);
		if($request->current_plan == 'basic')
		{
			$user->update(['current_plan' =>"premium",'card_change_limit'=>'1','created_plan'=> \Carbon\Carbon::now()]);
			return response()->json(['success'=>true,'message'=>'Current Plan Updated Successfully','user_info'=>$user,'payment' => $charge]);

		}
		elseif($request->current_plan == 'premium')
		{
			$user->update(['current_plan' =>"basic",'card_change_limit'=>'0','created_plan'=> \Carbon\Carbon::now()]);

		 return response()->json(['success'=>true,'message'=>'Current Plan Updated Successfully','user_info'=>$user]);
		}
		else
		{
			return $this->sendError("Invalid Body ");
		}
		}
		catch(\Exception $e){
	  return $this->sendError($e->getMessage());

		}

	}


}
