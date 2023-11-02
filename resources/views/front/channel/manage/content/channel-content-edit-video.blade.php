@extends('front.channel.manage.content.channel-content')

@section('head-title')
    {{ __('Video editing') . ": " . $video->title }}
@endsection

@section('channel-content-edit-video-form')
    <h4 class="text-center">{{ __('Video editing') }}: <span class="text-primary">{{ $video->title }}</span></h4><br>
    <div class="col-lg-10 mx-auto">
        <form action="{{ route('channel-content-update-video', $video->id) }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
            @csrf
            @method('put')
            <div class="mb-3 ">
                <label for="InputTitle" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') ? old('title') : $video->title }}">
                @error('title')
                    <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 ">
                <label for="InputDescription" class="form-label">{{ __('Description') }}</label>
                <textarea type="text" class="form-control videoTextArea @error('description') is-invalid @enderror" id="InputDescription" aria-describedby="descriptionHelp" name="description">{{ old('description') ? old('description') : $video->description }}</textarea>
                @error('description')
                    <div id="descriptionHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="photo-file" class="form-label">{{ __('Thumbnail') }}</label>
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForGenerateThumbnail" name="generateThumbnail" {{ old('generateThumbnail') == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="flexCheckDefaultForGenerateThumbnail">{{ __('Generate') }} {{ __('thumbnail') }}</label>
                </div>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img width="256" src="\images\thumbnails\{{ $video->thumbnail }}" class="img-thumbnail" alt="{{ __('Thumbnail') }} video">
                </div>
                <input class="form-control" type="file" accept="image/*" id="photo-file" name="thumbnail">
                @error('thumbnail')
                    <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="SelectVideoCategory" class="form-label">{{ __('Category') }}</label>
                <select name="video_category" class="form-select" aria-label="SelectVideoCategory">
                    @foreach ($categories as $category)
                        <option {{ $category->id == $video->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ __($category->title) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 ">
                <label for="Published" class="form-label">{{ __('Published') }}</label>
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForPublished" name="published" {{ $video->published == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="flexCheckDefaultForPublished">Public</label>
                </div>
            </div>
            <div class="mb-3 mx-auto col-lg-3">
                <button type="submit" class="btn btn-primary">{{ __('Edit video') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection

@section('ckeditor-script')
  @include('front.scripts.ckeditor-script')
@endsection