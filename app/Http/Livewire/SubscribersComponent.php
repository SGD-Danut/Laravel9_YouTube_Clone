<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class SubscribersComponent extends Component
{
    public $channel;
    public $user_id, $channel_id;

    public function subscribeToCurrentChannel() {
        //Inserare unica pentru o combinație de valori:
        if (auth()->check()) {
            if (auth()->user()->channel->id != $this->channel->id) {
                if (Subscriber::exists()) {
                    $theExistingSubscriberInTheDatabase = Subscriber::where('user_id', auth()->user()->id)->where('channel_id', $this->channel->id)->first();
                    if ($theExistingSubscriberInTheDatabase) {
                        $theExistingSubscriberInTheDatabase->delete();
                    } else {
                        Subscriber::firstOrCreate(['user_id' => auth()->user()->id, 'channel_id' => $this->channel->id]);
                    }
                } else {
                    Subscriber::firstOrCreate(['user_id' => auth()->user()->id, 'channel_id' => $this->channel->id]);
                }
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function render()
    {
        return view('livewire.subscribers-component');
    }
}
