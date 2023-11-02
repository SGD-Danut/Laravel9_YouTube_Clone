@extends('front.master.master-page')

@section('head-title')
    {{ __('Playlist') . ": " . $playlist->title }}
@endsection

@section('playlist-page-style')
  {{-- Video.js - player scripts --}}
  {{-- <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet" />
  <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script> --}}
  <link rel="stylesheet" href="\css\playlist-page.css">
@endsection

@section('content')
  @if ($playlist->published == 1 || (auth()->check() && $playlist->user_id == auth()->id())) 
    <div class="container">
      @if ($playlist->videos->count() > 0)
        <div class="main-video">
          <div class="video">
            {{-- From Video.js - player: --}}
            {{-- <video
                id="my-video"
                class="video-js"
                controls
                preload="auto"
                poster="\images\thumbnails\{{ $currentVideo->slug ? $currentVideo->thumbnail : $videosFromCurrentPlaylist[0]->thumbnail }}"
                data-setup="{}"
              >
                <source src="\videos\{{ $currentVideo->slug ? $currentVideo->file_path : $videosFromCurrentPlaylist[0]->file_path }}" type="video/mp4" />
                <p class="vjs-no-js">
                  To view this video please enable JavaScript, and consider upgrading to a
                  web browser that
                  <a href="https://videojs.com/html5-video-support/" target="_blank"
                    >supports HTML5 video</a
                  >
                </p>
              </video> --}}
            <video src="\videos\{{ $currentVideo->slug ? $currentVideo->file_path : $videosFromCurrentPlaylist[0]->file_path }}" controls muted autoplay></video>
            <a href="{{ route('show-current-video', $currentVideo->slug ? $currentVideo->slug : $videosFromCurrentPlaylist[0]->slug) }}">
              <h3 class="title">{{ $currentVideo->slug ? $currentVideo->title : $videosFromCurrentPlaylist[0]->title }}</h3>
            </a>
          </div>
        </div>
        <div>
          <h3 class="playlistRightTitle">{{ $playlist->title }}</h3>
          <div class="video-list">
              @foreach ($videosFromCurrentPlaylist as $video)
                <a href="{{ route('show-current-playlist', [$playlist->slug, $video->slug]) }}">
                  <div class="vid {{ $currentVideo->slug == $video->slug || ($videosFromCurrentPlaylist[0]->slug == $video->slug && empty($currentVideo->slug)) ? 'active' : '' }}">
                      <img src="\images\thumbnails\{{ $video->thumbnail }}" class="imageOfVideo" alt="">
                      <h3 class="title">{{ $video->title }}</h3>
                  </div>
                </a>
              @endforeach
          </div> 
        </div>
      @else
        <h2 class="no-playlist-message">{{ __('There are no videos added to this playlist!') }}</h2><br>
        <img src="/images/playlists/playlist-with-no-video.png" class="no-playlist" alt="Playlist with no video.">
      @endif
    </div>   
  @else
    @php
      abort(404);
    @endphp
  @endif
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection