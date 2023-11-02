@extends('front.master.master-page')

@section('head-title')
    {{ __('YouTube Clone') }}
@endsection

@section('content')
  <main>
    <h3 style="padding-bottom: 25px;">{{ __('Recommended videos:') }}</h3>
    <section class="video_content grid">
      @foreach ($videos as $video)
        <div class="video_items">
          <a href="{{ route('show-current-video', $video->slug) }}">
            <div class="video-thumbnail">
              <img src="images/thumbnails/{{ $video->thumbnail }}" alt="">
              <h6 class="video-duration"><span class="badge bottom-right">{{ $video->duration != null ? $video->duration : '00:00' }}</span></h6>
            </div>
          </a>
          <div class="details flex">
            <div class="img">
              <a href="{{ route('show-channel-home', $video->channel->slug) }}">
                <img src="images/avatars/{{ $video->channel->avatar }}" alt="" class="avatar-image">
              </a>
            </div>
            <div class="heading">
              <p title="{{ $video->title }}">{{ Str::limit($video->title, 30) }}</p>
              <a href="{{ route('show-channel-home', $video->channel->slug) }}">
                <span>{{ $video->channel->title }} <i class="fa fa-circle-check"></i> </span>
              </a>
              <br>
              <span>{{ $video->views }} {{ __('views') }} | {{ $video->created_at->format('d.m.Y') }} </span>
            </div>
          </div>
        </div>
      @endforeach
    </section>
  </main>
@endsection