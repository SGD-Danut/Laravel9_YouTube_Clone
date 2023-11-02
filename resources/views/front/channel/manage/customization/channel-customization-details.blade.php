@extends('front.channel.manage.customization.channel-customization')

@section('head-title')
  {{ __('Channel customization') . ": " . __('Basic info') }}
@endsection

@section('details')
  <form action=" {{ route('update-channel-details') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
    @csrf
    @method('put')
      <div class="mb-3">
        <h5>{{ __('Name') }}</h5>
        <label for="InputTitle" class="form-label">{{ __('Choose a channel name that represents you and your content. Changes made to your name and picture are visible only on YouTube and not other Google services.') }}</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') ? old('title') : $channel->title }}">
        @error('title')
            <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <h5>{{ __('Description') }}</h5>
        <label for="InputPresentation" class="form-label">{{ __('Tell viewers about your channel. Your description will appear in the About section of your channel and search results, among other places.') }}</label>
        <textarea type="text" class="form-control descriptionTextArea @error('description') is-invalid @enderror" id="InputDescription" aria-describedby="descriptionHelp" name="description">{{ old('description') ? old('description') : $channel->description }}</textarea>
        @error('description')
            <div id="descriptionHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <h5>{{ __('Channel URL') }}</h5>
        <label for="InputTitle" class="form-label">{{ __('This is the standard web address for your channel. It includes your unique channel ID, which is the numbers and letters at the end of the URL.') }}</label>
        <input class="form-control" type="text" value="{{ $channelURL }}" aria-label="readonly input example" readonly>
      </div>
      <div class="mb-3">
        <h5>{{ __('Contact info') }}</h5>
        <label for="InputTitle" class="form-label">{{ __('Let people know how to contact you with business inquiries. The email address you enter may appear in the About section of your channel and be visible to viewers.') }}</label>
        <input type="text" class="form-control @error('contact') is-invalid @enderror" id="InputContact" aria-describedby="contactHelp" name="contact" value="{{ $channel->contact }}">
        @error('contact')
        <div id="contactHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3 mx-auto col-lg-3">
        <button type="submit" class="btn btn-primary">{{ __('Publish the changes') }}</button>
      </div>
  </form>
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection