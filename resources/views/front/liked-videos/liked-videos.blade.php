@extends('front.master.master-page')

@section('head-title')
    {{ __('Liked videos') }}
@endsection

@section('history-page-style')
    <link rel="stylesheet" href="/css/history-page.css">
@endsection

@section('content')
    @if ($likedVideos->count() > 0)
        <h2>{{ __('Liked videos') }}:</h2>
        @foreach ($likedVideos as $video)
            <div class="image-container">
                <a href="{{ route('show-current-video', $video->slug) }}">
                    <img src="\images\thumbnails\{{ $video->thumbnail }}" alt="Video image" width="246" height="auto">
                </a>
                <div class="caption">
                    <h2>{{ $video->title }}</h2>
                    <p>{!! substr($video->description, 0, 135) !!}{{ strlen($video->description) > 135 ? "..." : ""}}</p>
                </div>
            </div>  
        @endforeach
        <div class="pagination-menu">
            {{ $likedVideos->links() }}
        </div>
    @else
        <h2>{{ __("You haven't liked any videos") }}!</h2>
    @endif
@endsection