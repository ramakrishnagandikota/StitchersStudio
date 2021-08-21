<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeToPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
	public $timeline;
	public $userDetails;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($timeline,$userDetails)
    {
        $this->timeline = $timeline;
		$this->userDetails  = $userDetails;
        $this->message = 'Likes your post';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //print_r($this->timeline);
		return ['like-post-'.$this->timeline];
		//print_r($this->timeline);
        //return new PrivateChannel('channel-name');
		//return new Channel('like-post'.$this->timeline->user_id);
    }
	
/*	public function broadcastAs()
  {
      return 'like-post';
  } */
}
