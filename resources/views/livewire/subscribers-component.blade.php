<div>
    <span class="fw-bold">{{ $channel->subscribers()->count()}} {{ __('Subscribers') }}</span>
    @if (auth()->check() && auth()->user()->channel_id != null)
        @if (auth()->user()->channel->id != $channel->id)
            @if (Auth::user()->subscribedChannels->contains($channel))
                <button class="btn btn-sm btn-danger unsubscribeButton" wire:click="subscribeToCurrentChannel()">{{ __('Unsubscribe') }}</button>
            @else
                <button class="btn btn-sm btn-primary subscribeButton" wire:click="subscribeToCurrentChannel()">{{ __('Subscribe') }}</button>
            @endif
        @endif
    @elseif (auth()->check() && auth()->user()->channel_id == null)
        <h6 style="font-size: 14px;font-family: inherit;"><a href="{{ route('show-new-channel-form') }}" style="color: royalblue;">{{ __('Create') }}</a> {{ __('a channel') }} {{ __('to subscribe') }}.</h6>
    @else
        <h6 style="font-size: 14px;font-family: inherit;"><a href="{{ route('login') }}" style="color: royalblue;">{{ __('Sign in') }}</a> {{ __('to subscribe') }}.</h6>
    @endif
</div>
