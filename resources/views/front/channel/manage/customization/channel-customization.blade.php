@extends('front.channel.manage.master.master-page')

@section('head-title')
  {{ __('Channel customization') }}
@endsection

@section('content')
  <div class="px-4 py-4 my-5 text-center">
      <h2>{{ __('Channel customization') }} <span><img src="/images/youtube-customize.png" width="100" alt=""></span></h2>
      <div class="col-lg-8 mx-auto">
        <ul class="nav nav-pills nav-fill">
          <li class="nav-item">
            <a class="nav-link {{ isset($layout) ? 'active' : '' }}" aria-current="page" href="{{ route('customize-channel-layout') }}">{{ __('Layout') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ isset($branding) ? 'active' : '' }}" href="{{ route('customize-channel-branding') }}">{{ __('Branding') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ isset($details) ? 'active' : '' }}" href="{{ route('customize-channel-details') }}">{{ __('Basic info') }}</a>
          </li>
        </ul>
      </div>
  </div>
  <div class="col-lg-8 mx-auto">
    @if (isset($channelCustomizationPage))
      <h5>{{ __('Welcome to channel customization!') }} {{ __('Choose an option from above to get started.') }}</h5>
    @endif
    @yield('branding')
    @yield('details')
    @yield('layout')
  </div>
@endsection
