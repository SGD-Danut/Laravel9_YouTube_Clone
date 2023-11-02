@extends('admin.master.master-page')

@section('head-title')
    {{ __('Adding category') }}
@endsection

@section('big-title')
    {{ __('Adding category') }}
@endsection

@section('content')
    <form action="{{ route('create-new-category') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 col-md-4">
            <label for="InputTitle" class="form-label">{{ __('Title') }}</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') }}">
            @error('title')
                <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 mx-auto col-lg-3">
            <button type="submit" class="btn btn-primary">{{ __('Add category') }}</button>
        </div>
    </form>
@endsection
