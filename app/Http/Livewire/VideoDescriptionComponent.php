<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class VideoDescriptionComponent extends Component
{
    public $video;
    public $finalVideoDescription;

    public function showFullLenghtDescription() {
        $this->finalVideoDescription = $this->video->description;
    }

    public function showSmallLenghtDescription() {
        $this->finalVideoDescription = Str::limit($this->video->description, 61);
    }

    public function render()
    {
        if ($this->finalVideoDescription == null) {
            $this->showSmallLenghtDescription();
        }
        
        return view('livewire.video-description-component', [$this->finalVideoDescription]);
    }
}
