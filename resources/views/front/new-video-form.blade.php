@extends('front.master.master-page')

@section('head-title')
    {{ __('Adding video') }}
@endsection

@section('bootstrap')
    <link rel="stylesheet" href="/bootstrap-5.2.2/css/bootstrap.min.css">
@endsection

@section('custom-css')
    <link rel="stylesheet" href="css/custom.css">
@endsection

@section('content')
    <div class="px-4 py-2 my-2 text-center">
        <h1 class="display-6 fw-bold">{{ __('Adding video') }}</h1>
    </div>
    <div class="col-lg-10 mx-auto">
        @include('messages')
        <form action=" {{ route('add-new-video') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
            @csrf
            <div class="mb-3">
                <label for="video-file" class="form-label">{{ __('Video file') }}</label>
                <input class="form-control" type="file" accept="video/*" id="video-file" name="videoFile">
                @error('videoFile')
                    <div id="videoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="video-file" class="form-label">{{ __('Video compression') }}</label>
                    <p>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        {{ __('Show compression details') }}
                        </button>
                    </p>
                  <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="needsCompression" value="no" id="needsCompression1">
                                <label class="form-check-label" for="needsCompression1">
                                {{ __('Already compressed') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="needsCompression" value="yes-auto" id="needsCompression2" checked>
                                <label class="form-check-label" for="needsCompression2">
                                {{ __('Automatic compression') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="needsCompression" value="yes-custom" id="needsCompression2">
                                <label class="form-check-label" for="needsCompression2">
                                {{ __('Custom compression by resolution:') }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Select resolution') }}</label>
                                <select name="resolution" class="form-control">
                                    <option value="426x240">240p</option>
                                    <option value="640x360">360p</option>
                                    <option value="854x480">480p</option>
                                    <option value="1280x720">720p</option>
                                    <option value="1920x1080" selected>1080p</option>
                                </select>
                                <span class="text-warning">{{ __('Attention, the resolutions are for videos with 16:9 aspect ratio!') }}</span><br>
                                <span class="text-danger">{{ __("Using this conversion method for videos with aspect ratios different than 16:9 will lead to distorting the video's aspect ratio.") }}</span><br>
                                <span class="text-success">{{ __('We recommend using') }} <b>{{ __('automatic compression') }}</b>.</span>
                            </div>
                        </div>
                  </div>
            </div>
            <div class="mb-3">
                <label for="InputTitle" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') }}">
                @error('title')
                    <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="InputDescription" class="form-label">{{ __('Description') }}</label>
                <textarea type="text" class="form-control postTextArea @error('description') is-invalid @enderror" id="InputDescription" aria-describedby="descriptionHelp" name="description" value="{{ old('description') }}"></textarea>
                @error('description')
                    <div id="descriptionHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="photo-file" class="form-label">{{ __('Thumbnail') }}</label>
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForGenerateThumbnail" name="generateThumbnail" {{ old('generateThumbnail') == 1 ? 'checked' : ''}} checked>
                    <label class="form-check-label" for="flexCheckDefaultForGenerateThumbnail">{{ __('Generate') }} {{ __('thumbnail') }}</label>
                </div>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img src="\images\thumbnails\defaultThumbnailImage.png" class="img-thumbnail" alt="Imagine de previzualizare video">
                </div>
                <input class="form-control" type="file" accept="image/*" id="photo-file" name="thumbnail">
                @error('image')
                    <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
            <label for="SelectVideoCategory" class="form-label">{{ __('Category') }}</label>
                <select name="video_category" class="form-select" aria-label="SelectVideoCategory">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ __($category->title) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="Published" class="form-label">{{ __('Published') }}</label>
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForPublished" name="published" {{ old('published') == 1 ? 'checked' : ''}} checked>
                    <label class="form-check-label" for="flexCheckDefaultForPublished">Public</label>
                </div>
            </div>
            <div class="mb-3 mx-auto col-lg-3">
                <button type="submit" class="btn btn-primary">{{ __('Add video') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('image-preview-script')
    @include('front.scripts.image-preview-script')
@endsection
