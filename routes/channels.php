<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId; // Check if $receiver is currently authenticated user
});

Broadcast::channel('conversation.{receiverId}', function ($user, $receiverId) {
    $userExists = User::where('id', $receiverId)->exists(); // Check if user exists
     
    return $userExists ? ['id' => $user->id, 'name' => $user->name] : false; 
});