<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Auth;

class MessageController extends BaseController
{
    public function message_list(Request $request)
    {
        $userid = Auth::id();
        $targetid = $request->target_id;
        $rideid = $request->ride_id;

        $chat = Conversation::where(function ($query) use ($userid) {
            $query->where('user_id', $userid);
                // ->where('target_id', $targetid);
        })->orWhere(function ($query) use ($userid) {
            $query->where('target_id', $userid);
                // ->where('target_id', Auth::id());
        })->first();
        $data = Message::where('chat_id',$chat->id)->get();
        return $this->sendResponse($data ,'Messages Lists');
    }

    // public function sendMessage(Request $request)
    // {
    //     $message = [
    //         'chat_id' => $request->chat_id,
    //         'target_id' => $request->target_id,
    //         'text' => $request->text,
    //         'createdAt' => $request->createdAt,
    //         'user' => $request->user,
    //     ];

    //     $chat = Conversation::where('user_id',Auth::user()->id)->orwhere('target_id',Auth::user()->id)->first();
    //     if(!$chat)
    //     {
    //         $chat = Conversation::create([
    //             // 'chat_id' => request()->chat_id,
    //             'user_id' => request()->chat_id, //Auth::user()->id,
    //             'target_id' => request()->target_id,
    //         ]);
    //     }

    //     Message::create([
    //         'chat_id' => Auth::user()->id,
    //         'user_id' => Auth::user()->id,
    //         'target_id' => request()->target_id,
    //         'text' => request()->text,
    //         'user' => json_encode($request->user),
    //     ]);

    //     // Broadcast the event
    //     broadcast(new MessageSent((object)$message))->toOthers();

    //     return response()->json(['status' => 'Message Sent!']);
    // }

    public function sendMessage(Request $request)
    {
        // return Auth::user()->id;
        // dd($request->user['id']);

        $message = [
            'chat_id' => $request->chat_id,
            'target_id' => $request->target_id,
            'text' => $request->text,
            'createdAt' => $request->createdAt,
            'user' => $request->user,
        ];


        $userid = Auth::id();
        $targetid = $request->target_id;
        $ride_id = $request->ride_id;
        $chat = Conversation::where(function ($query) use ($userid, $targetid) {
            $query->where('user_id', $userid)
                ->where('target_id', $targetid);
                // ->where('ride_id', $ride_id);
            })->orWhere(function ($query) use ($userid, $targetid) {
                $query->where('user_id', $targetid)
                ->where('target_id', Auth::id());
                // ->where('ride_id', $ride_id);
            })->first();
        if(!$chat)
        {
            $chat = Conversation::create([
                // 'ride_id' => request()->ride_id,
                'user_id' => request()->chat_id, //Auth::user()->id,
                'target_id' => request()->target_id,
            ]);

        }
        // return $chat->id;
        // return json_dencode(request()->user);
        Message::create([
            'chat_id' => $chat->id,
            'user_id' => Auth::user()->id,
            'target_id' => request()->target_id,
            'text' => request()->text,
            'user' => json_encode($request->user)
        ]);

        // Broadcast the event
        broadcast(new MessageSent((object)$message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }

}
