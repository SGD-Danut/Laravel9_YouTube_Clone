@extends('front.channel.manage.master.master-page')

@section('head-title')
{{ __('Channel content') }}
@endsection

@section('content')
  <div class="px-4 py-4 my-5 text-center">
      <h2>{{ __('Channel content') }} <span><img src="/images/youtube-content.png" width="100" alt=""></span></h2>
      <div class="col-lg-8 mx-auto">
        <ul class="nav nav-pills nav-fill">
          <li class="nav-item">
            <a class="nav-link {{ isset($channelVideos) ? 'active' : '' }}" aria-current="page" href="{{ route('channel-content-videos') }}">{{ __('Videos') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ isset($channelPlaylists) ? 'active' : '' }}" aria-current="page" href="{{ route('channel-content-playlists') }}">{{ __('Playlists') }}</a>
          </li>
        </ul>
      </div>
  </div>
  <div class="col-lg-8 mx-auto">
    @if (isset($channelContentPage))
      <h5>{{ __('Welcome to the channel content! Choose an option above to get started.') }}</h5>
    @endif
    @yield('videos')
    @yield('playlists')
    @yield('current-user-playlist')
    @yield('channel-content-edit-video-form')
    @yield('channel-content-edit-playlist-form')
  </div>
@endsection