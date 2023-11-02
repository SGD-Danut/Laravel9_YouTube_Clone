@extends('front.master.master-page')

@section('head-title')
  {{ $channel->title }}
@endsection

@section('bootstrap')
  <link rel="stylesheet" href="/bootstrap-5.2.2/css/bootstrap.min.css">
@endsection

@section('custom-css')
  <link rel="stylesheet" href="/css/custom.css">
@endsection

@section('content')
  <div class="px-4 py-2 my-2 text-center">
      @if ($channel->banner != null)
        <img src="/images/banners/{{ $channel->user->channel_id != null ? $channel->banner : 'default-banner.jpg'}}" class="img-fluid cover-photo" alt="...">
      @endif 
  </div>
  <div class="col-lg-11 mx-auto">
    <div class="details flex">
        <div class="channel-image img-thumbnail">
          <img src="/images/avatars/{{ $channel->avatar }}" alt="" class="avatar-image">
        </div>
        <div class="heading channel-details">
          <h1 class="display-6 fw-bold">{{ $channel->title }}  <i class="fa fa-circle-check checked-account"></i></h1>
          <livewire:subscribers-component :channel="$channel">
        </div>
    </div>
    @if (auth()->id() == $channel->user_id)
      <br>
      <div class="manage-buttons">
      <a href="{{ route('customize-channel-layout') }}" class="btn btn-primary my-2">{{ __('Customize channel') }}</a>
      <a href="{{ route('channel-content-videos') }}" class="btn btn-primary my-2">{{ __('Manage Videos') }}</a>
    </div>
    @endif
    <ul class="nav nav-tabs channel-navigation">
      <li class="nav-item">
        <a class="nav-link {{ isset($home) ? 'active' : '' }}" aria-current="page" href="{{ route('show-channel-home', $channel->slug) }}">{{ __('Home') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ isset($videos) ? 'active' : '' }}" aria-current="page" href="{{ route('show-channel-videos', $channel->slug) }}">{{ __('Videos') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ isset($playlists) ? 'active' : '' }}" aria-current="page" href="{{ route('show-channel-playlists', $channel->slug) }}">{{ __('Playlists') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ isset($about) ? 'active' : '' }}" href="{{ route('show-channel-details', $channel->slug) }}">{{ __('About') }}</a>
      </li>
    </ul>
  </div>
  @yield('home')
  @yield('videos')
  @yield('playlists')
  @yield('details')
@endsection

