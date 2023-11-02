@extends('front.channel.manage.customization.channel-customization')

@section('head-title')
  {{ __('Channel customization') . ": " . __('Layout') }}
@endsection

@section('layout')
  @if (auth()->user()->channel->videos->count() > 0) 
  <form action=" {{ route('update-channel-layout') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
    @csrf
    @method('put')
      <div class="mb-3">
        <h5>{{ __('Video spotlight') }} </h5>
        <label for="SelectSpecialVideo" class="form-label">{{ __('Add a video to the top of your channel homepage') }} </label>
        <select name="special_video" class="form-select" aria-label="SelectSpecialVideo">
          @foreach ($videos as $video)
              <option {{ $video->id == auth()->user()->channel->special_video ? 'selected' : '' }} value="{{ $video->id }}">{{ $video->title }}</option>
          @endforeach
        </select>
        @error('special_video')
            <div id="specialVideoHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3 mx-auto col-lg-3">
        <button type="submit" class="btn btn-primary">{{ __('Publish the changes') }}</button>
      </div>
  </form>    
  @else
    @include('front.channel.parts.empty-channel-message')
  @endif
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection