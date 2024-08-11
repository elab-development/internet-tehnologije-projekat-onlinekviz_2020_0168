<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionProgressUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomName;
    public $username;
    public $questionNumber;

    public function __construct($roomName, $username, $questionNumber)
    {
        $this->roomName = $roomName;
        $this->username = $username;
        $this->questionNumber = $questionNumber;

        Log::info('Event fired: QuestionProgressUpdated', [
            'roomName' => $roomName,
            'username' => $username,
            'questionNumber' => $questionNumber
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('quiz-room.' . $this->roomName);
    }
}

