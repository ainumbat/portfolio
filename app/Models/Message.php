<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    /**
     * Relationship: A message belongs to a sender (User).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship: A message belongs to a receiver (User).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
