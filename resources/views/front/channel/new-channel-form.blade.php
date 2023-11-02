@extends('front.master.master-page')

@section('head-title')
    {{ __('Creating channel') }}
@endsection

@section('bootstrap')
    <link rel="stylesheet" href="/bootstrap-5.2.2/css/bootstrap.min.css">
@endsection

@section('custom-css')
    <link rel="stylesheet" href="css/custom.css">
@endsection

@section('content')
    <div class="px-4 py-2 my-2 text-center">
        <h1 class="display-6 fw-bold">{{ __("You don't have a channel yet!") }}</h1>
        <h4>{{ __('Create your own!') }}</h4>
    </div>
    <div class="col-lg-8 mx-auto">
        <form action=" {{ route('create-new-channel') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
            @csrf
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
                <label for="InputContact" class="form-label">{{ __('Contact Information') }}</label>
                <textarea type="text" class="form-control postTextArea @error('contact') is-invalid @enderror" id="InputContact" aria-describedby="contactHelp" name="contact" value="{{ old('contact') }}"></textarea>
                @error('contact')
                    <div id="contactHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="photo-file" class="form-label">{{ __('Avatar picture') }}</label>
                    <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                        <img src="\images\avatars\default-avatar.png" class="img-thumbnail" alt="{{ __('Avatar picture') }}">
                    </div>
                <input class="form-control" type="file" accept="image/*" id="photo-file" name="avatar">
                @error('avatar')
                    <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 mx-auto col-lg-3">
                <button type="submit" class="btn btn-primary">{{ __('Create channel') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('image-preview-script')
    @include('front.scripts.image-preview-script')
@endsection