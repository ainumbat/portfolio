<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all()->except(1);

        return Inertia::render('Dashboard', ['users' => $users]);
    }

    public function send_message(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        $message = Message::create($validated);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message], 201);
    }

    public function load_chat(User $receiver)
    {
        $recent_chat = Message::query()
            ->where(function ($query) use ($receiver) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($query) use ($receiver) {
                $query->where('sender_id', $receiver->id)
                    ->where('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json(['recent_chat' => $recent_chat], 201);
    }
}
