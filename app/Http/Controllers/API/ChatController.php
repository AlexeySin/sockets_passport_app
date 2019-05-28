<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function show()
    {
        return view('index');
    }
    public function fetchMessages()
    {
        return Message::with('author')->get()->toJson(JSON_PRETTY_PRINT);
    }
    public function send(Request $request)
    { 
       \Auth::user()->messages()->create(['content'=> $request->message]);   
       MessageSent::dispatch($request->message);
       return $this->fetchMessages();
    }
}
