@extends('front.master.master-page')

@section('head-title')
    {{ __('Library') }}
@endsection

@section('history-page-style')
    <link rel="stylesheet" href="/css/library-page.css">
@endsection

@section('content')
  @if ($historyFromCurrentUser->count())
    <h2>{{ __('Previously watched videos:') }}</h2>
  @else
      <h2>{{ __("You don't have any videos in your history") }}!</h2>
  @endif
  <main>
    <section class="video_content grid">
      @inject('video', 'App\Models\Video')
      @foreach ($historyFromCurrentUser->take(5) as $history)
        <div class="video_items">
          <a href="{{ route('show-current-video', $video::find($history->video_id)->slug) }}">
            <div class="video-thumbnail">
              <img src="\images\thumbnails\{{ $video::find($history->video_id)->thumbnail }}" alt="">
              <h6 class="video-duration"><span class="badge bottom-right">{{ $video::find($history->video_id)->duration != null ? $video::find($history->video_id)->duration : '00:00' }}</span></h6>
            </div>
          </a>
          <div class="details flex">
            <div class="heading">
              <p>{{ $video::find($history->video_id)->title }}</p>
              <a href="{{ route('show-channel-home', $video::find($history->video_id)->channel->slug) }}">
                <span>{{ $video::find($history->video_id)->channel->title }}</span>
              </a>
              <br>
              <span>{{ $video::find($history->video_id)->views }} {{ __('views') }} | {{ $video::find($history->video_id)->created_at->diffForHumans() }} </span>
            </div>
          </div>
        </div>
      @endforeach
    </section>
  </main>
  @if ($historyFromCurrentUser->count() > 5)
      <a href="{{ route('history') }}" class="show-more-link">{{ __('Show all') }}</a>
  @endif
  @if ($playlistsFromCurrentUser->count())
    <h2>{{ __('Your playlists:') }}</h2>
  @else
    <h2>{{ __('You have no playlist') }}!</h2>
  @endif
  <main>
    <section class="video_content grid">
      @foreach ($playlistsFromCurrentUser->take(5) as $playlist)
        <div class="video_items">
          <a href="{{ route('show-current-playlist', $playlist->slug) }}">
            <div class="video-thumbnail">
              <img src="/images/playlists/{{ $playlist->thumbnail }}" alt="Lipsa imagine de tip thumbnail" style="max-height: 120px; max-width:fit-content">
            </div>
          </a>
          <div class="details flex">
            <div class="heading">
              <p>{{ $playlist->title }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </section>
  </main>
  @if ($playlistsFromCurrentUser->count() > 5)
      <a href="{{ route('channel-content-playlists') }}" class="show-more-link">{{ __('Show all') }}</a>
  @endif
  
  @if ($likedVideos->count())
    <h2>{{ __('Videos liked by you:') }}</h2>
  @else
      <h2>{{ __("You haven't liked any video") }}!</h2>
  @endif
  <main>
    <section class="video_content grid">
      @foreach ($likedVideos->take(5) as $video)
        <div class="video_items">
          <a href="{{ route('show-current-video', $video->slug) }}">
            <div class="video-thumbnail">
              <img src="\images\thumbnails\{{ $video->thumbnail }}" alt="">
              <h6 class="video-duration"><span class="badge bottom-right">{{ $video->duration != null ? $video->duration : '00:00' }}</span></h6>
            </div>
          </a>
          <div class="details flex">
            <div class="heading">
              <p>{{ $video->title }}</p>
              <a href="{{ route('show-channel-home', $video->channel->slug) }}">
                <span>{{ $video->channel->title }}</span>
              </a>
              <br>
              <span>{{ $video->views }} {{ __('views') }} | {{ $video->created_at->diffForHumans() }} </span>
            </div>
          </div>
        </div>
      @endforeach
    </section>
  </main>
  @if ($likedVideos->count() > 5)
      <a href="{{ route('liked-videos') }}" class="show-more-link">{{ __('Show all') }}</a>
  @endif
@endsection