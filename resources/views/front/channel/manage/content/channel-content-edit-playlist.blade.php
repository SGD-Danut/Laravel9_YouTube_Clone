@extends('front.channel.manage.content.channel-content')

@section('head-title')
    {{ __('Edit playlist') . ": " . $playlist->title }}
@endsection

@section('channel-content-edit-playlist-form')
    <h4 class="text-center">{{ __('Edit playlist') }}: <span class="text-primary">{{ $playlist->title }}</span></h4><br>
    <div class="col-lg-10 mx-auto">
        <form action="{{ route('channel-content-update-playlist', $playlist->id) }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
            @csrf
            @method('put')
            <div class="mb-3 ">
                <label for="InputTitle" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') ? old('title') : $playlist->title }}">
                @error('title')
                    <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 ">
                <label for="InputDescription" class="form-label">{{ __('Description') }}</label>
                <textarea type="text" class="form-control playlistTextArea @error('description') is-invalid @enderror" id="InputDescription" aria-describedby="descriptionHelp" name="description">{{ old('description') ? old('description') : $playlist->description }}</textarea>
                @error('description')
                    <div id="descriptionHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="photo-file" class="form-label">{{ __('Thumbnail') }}</label>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img width="256" src="\images\playlists\{{ $playlist->thumbnail }}" class="img-thumbnail" alt="Imagine de previzualizare playlist">
                </div>
                <input class="form-control" type="file" accept="image/*" id="photo-file" name="thumbnail">
                @error('thumbnail')
                    <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 ">
                <label for="Published" class="form-label">{{ __('Published') }}</label>
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForPublished" name="published" {{ $playlist->published == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="flexCheckDefaultForPublished">Public</label>
                </div>
            </div>
            <div class="mb-3 mx-auto col-lg-3">
                <button type="submit" class="btn btn-primary">{{ __('Edit playlist') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection