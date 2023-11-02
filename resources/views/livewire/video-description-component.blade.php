<div>
    <h5>{!! $finalVideoDescription !!}</h5>
    @if (strlen($finalVideoDescription) < strlen($video->description))
        <span wire:click="showFullLenghtDescription()" style="cursor: pointer;">{{ __('Show More') }}</span>
    @elseif ((strlen($finalVideoDescription) == strlen($video->description)) && (strlen($finalVideoDescription) > 60))
        <span wire:click="showSmallLenghtDescription()" style="cursor: pointer;">{{ __('Show Less') }}</span>
    @endif 
</div>
