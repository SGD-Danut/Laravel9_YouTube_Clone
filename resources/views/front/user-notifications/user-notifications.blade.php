@extends('front.master.master-page')

@section('head-title')
    {{ __('Notifications') }}
@endsection

@section('content')
    <h2>{{ __('Notifications') }}:</h2>
    @foreach ($currentUserNotifications as $notification)
        <div class="notification-container">
            <div class="notification-content">
                @if ($notification->video_upload_notify == 1)
                    <h3 class="notification-text">{{ __('The channel') }} <a href="{{ route('show-channel-home', $notification->channel->slug) }}"><span style="color: rebeccapurple">{{ $notification->channel->title }}</span></a> {{ __('has added a new video:') }} <a href="{{ route('show-current-video', $notification->video->slug) }}"><span style="color: rebeccapurple">{{ $notification->video->title }}</span></a></h3>
                @elseif ($notification->video_comment_notify == 1)
                    <h3 class="notification-text">{{ __('The channel') }} <a href="{{ route('show-channel-home', $notification->channel->slug) }}"><span style="color: rebeccapurple">{{ $notification->channel->title }}</span></a> {{ __('has added a new comment to the video:') }} <a href="{{ route('show-current-video', $notification->video->slug) }}"><span style="color: rebeccapurple">{{ $notification->video->title }}</span></a></h3>
                @elseif ($notification->comment_reply_notify == 1)
                    <h3 class="notification-text">{{ __('The channel') }} <a href="{{ route('show-channel-home', $notification->channel->slug) }}"><span style="color: rebeccapurple">{{ $notification->channel->title }}</span></a> {{ __('has added a response to your comment on the video:') }} <a href="{{ route('show-current-video', $notification->video->slug) }}"><span style="color: rebeccapurple">{{ $notification->video->title }}</span></a></h3>
                @endif
                <form action="{{ route('delete-user-notification', $notification->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="delete-notification-button" type="submit"><i class="fas fa-times"></i></button>
                </form>    
            </div>
        </div>
    @endforeach
@endsection