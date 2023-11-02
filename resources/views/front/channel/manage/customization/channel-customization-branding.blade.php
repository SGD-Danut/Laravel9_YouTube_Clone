@extends('front.channel.manage.customization.channel-customization')

@section('head-title')
  {{ __('Channel customization') . ": " . __('Branding') }}
@endsection

@section('branding')
  <form action=" {{ route('update-channel-branding') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
    @csrf
    @method('put')
      <h5>{{ __('Picture') }} </h5>
      <p>{{ __('Your profile picture will appear where your channel is presented on YouTube, like next to your videos and comments') }}</p>
      <div class="mb-3">
        <div class="card mb-3" style="max-width: 600px;">
          <div class="row g-0">
            <div class="col-md-4" id="image-preview">
              <img src="\images\avatars\{{ auth()->user()->channel->avatar != 'default-avatar.png' ? auth()->user()->channel->avatar : 'default-avatar.png' }}" class="img-fluid rounded-start" alt="Imagine avatar">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <p class="card-text">{{ __("It's recommended to use a picture that's at least 98 x 98 pixels and 4MB or less. Use a PNG or GIF (no animations) file. Make sure your picture follows the YouTube Community Guidelines.") }}</p>
                <input class="form-control" type="file" accept="image/*" id="photo-file" name="avatar">
                @error('avatar')
                    <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>
      <h5>{{ __('Banner image') }} </h5>
      <p>{{ __('This image will appear across the top of your channel') }}</p>
      <div class="mb-3">
        <div class="card mb-3" style="max-width: 950px;">
          <div class="row g-0">
            <div class="col-md-4" id="image-preview">
              <img src="\images\youtube-banner.png" class="img-fluid rounded-start" alt="Imagine banner">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <p class="card-text">{{ __("For the best results on all devices, use an image that's at least 2048 x 1152 pixels and 6MB or less.") }}</p>
                <input class="form-control" type="file" accept="image/*" id="photo-file" name="banner">
                @error('avatar')
                    <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-3 mx-auto col-lg-3">
        <button type="submit" class="btn btn-primary">{{ __('Publish the changes') }}</button>
      </div>
  </form>
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection