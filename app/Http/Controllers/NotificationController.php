<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Notifications\StatusNotification;
use App\Models\User;
use Auth;
use Helper;

class NotificationController extends Controller
{
    
    public function index()
    {
        $data['noti'] =  $unreadNotifications = Auth::user()->unreadNotifications;
        return view('backend.notification',$data);
    }
    
    public function noticount()
    {
        $noti =  $unreadNotifications = Auth::user()->unreadNotifications;
        return count($noti);
    }

    public function helper()
    {
        return $helper = Helper::goal_history(1);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $notification = Notification::find($id);
        $notification->update(['read_at' => now()]);
        return redirect()->to('/admin/car-ride-new');
    }

    public function edit(Notification $notification)
    {
        //
    }

    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function destroy(Notification $notification)
    {
        //
    }
}
