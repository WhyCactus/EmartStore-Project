<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ClientChatController extends Controller
{
    public function index()
    {
        return view('client.pages.chat');
    }

    public function getMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
        ]);

        broadcast(new MessageSent(auth()->user(), $message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }
}
