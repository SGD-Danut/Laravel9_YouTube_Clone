@extends('front.master.master-page')

@section('head-title')
    {{ $video->title }}
@endsection

@section('current-video-css')
  {{-- <link rel="stylesheet" href="{{ URL::asset('css/single.css'); }}"> --}}
  <link rel="stylesheet" href="/css/single.css">
  <link rel="stylesheet" href="/css/share-save-video-modal.css">
@endsection

@section('content')

  <!-- Share Modal start: -->
  <div id="shareModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>{{ __('Share with others what you have seen') }}! 🙂</h2>
      </div>
      <div class="modal-body">
        <p>{{ __("Copy the video's address below. And send it to those close to you") }}.</p>
        <!-- The text field -->
        <input type="text" class="inputVideoURL" value="{{ $videoURL }}" id="shareModalInput">
        <!-- The button used to copy the text -->
        <button class="copyVideoAdressButton" onclick="copyToClipboardCode()">{{ __('Copy') }}</button>
      </div>
      <div class="modal-footer">
        <h3> </h3>
      </div>
    </div>
  </div>
  <!-- Share Modal end. -->

  <main class="single_pages">
    <section class="video_items flex">
      <div class="left">
        <div class="left_content">
          <video controls autoplay muted>
            <source src="/videos/{{ $video->file_path }}" type="video/mp4" poster="/images/thumbnails/{{ $video->thumbnail }}">
          </video>

          <!--        video tages            -->
          <div class="tag">
            {{-- <label class="tags">#web #webdesign #Frontend </label> --}}
            <p>{{ $video->title }}</p>
          </div>
          <!--        video tages            -->

          <!--        total viwer            -->
          <div class="view flex2 border_bottom">
            <div class="view-text">
              <span>{{ $video->views }} {{ __('views') }} | {{ __('Added on:') }} {{ $video->created_at->format('d.m.Y - H:i') }}</span>
            </div>
            
            <div class="flex">
              <livewire:like-dislike-video-component :video="$video">
              <div class="icon">
                <!-- Trigger/Open The Modal -->
                <button type="button" id="shareModalBtn" class="fa fa-share mini-button"></button>
                <label>{{ __('Share') }}</label>
              </div>
              {{-- <div class="icon">
                <i class="fa fa-scissors"></i>
                <label>CLIP</label>
              </div> --}}
              <livewire:save-video-to-playlist-component :video="$video">
              {{-- <div class="icon">
                <i class="fa fa-ellipsis"></i>
              </div> --}}
            </div>
          </div>
          <!--        total viwer            -->


          <!--        video details            -->
          <div class="details flex border_bottom">
            <div class="img">
            <a href="{{ route('show-channel-home', $video->channel->slug) }}">
                <img src="/images/avatars/{{ $video->channel->avatar }}" alt="" class="avatar-image">
            </a>
            </div>
            <div class="heading">
              <a href="{{ route('show-channel-home', $video->channel->slug) }}">
                <h4 class="channel-name">{{ $video->channel->title }} <i class="fa fa-circle-check"></i> </h4>
              </a>
              <livewire:subscribers-component :channel="$video->channel">
              <livewire:video-description-component :video="$video">
            </div>
          </div>
          <!--        video details            -->

          <livewire:comments-component :video="$video">
        </div>
      </div>

      <div class="right">
        <div class="right_content">
          {{-- <button class="chat">Show Chat Replay</button> --}}
          {{-- <div class="tags">
            <label class="tags-bg">All</label>
            <label class="tags-bg">Web Design</label>
            <label class="tags-bg">Frontend</label>
            <label class="tags-bg">Backend</label>
          </div> --}}
          @foreach ($videos as $video)
          <div class="video_items vide_sidebar flex">
            <a href="{{ route('show-current-video', $video->slug) }}">
              <div class="video-thumbnail">
                <img src="/images/thumbnails/{{ $video->thumbnail }}" alt="">
                <h6 class="video-duration"><span class="badge bottom-right">{{ $video->duration != null ? $video->duration : '00:00' }}</span></h6>
              </div>
            </a>
            <div class="details">
              <p>{{ $video->title }}</p>
              <a href="{{ route('show-channel-home', $video->channel->slug) }}">
                <span>{{ $video->channel->title }} <i class="fa fa-cricle-check"> </i> </span><br>
              </a>
              <span>{{ $video->views }} {{ __('views') }}</span><br>
              <span>{{ $video->created_at->diffForHumans() }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  </main>
@endsection

@section('share-video-modal-script')
  @include('front.scripts.share-video-modal-script')
@endsection

@section('save-video-modal-script')
  @include('front.scripts.save-video-modal-script')
@endsection

