@extends('front.master.master-page')

@section('head-title')
    {{ __('Search results for:') . " " . $searchVideoTerm }}
@endsection

@section('history-page-style')
    <link rel="stylesheet" href="/css/history-page.css">
@endsection

@section('content')
    @isset($searchVideoTerm)
        @if ($videos->count())
            <h2><span style="color: teal">{{ $videos->total() }}</span> {{ __('videos were found for the term:') }} <span style="color: teal">{{ $searchVideoTerm }}</span></h2>
        @else
            <h2>{{ __('No videos were found for the term:') }} <span style="color: teal">{{ $searchVideoTerm }}</span></h2>
        @endif
        
        @foreach ($videos as $video)
            <div class="image-container">
                <a href="{{ route('show-current-video', $video->slug) }}">
                    <img src="\images\thumbnails\{{ $video->thumbnail }}" alt="Video image" width="246" height="auto">
                </a>
                <div class="caption">
                    <h2>{{ $video->title }}</h2>
                    <p>{!! substr($video->description, 0, 155) !!}{{ strlen($video->description) > 155 ? "..." : ""}}</p>
                </div>
            </div>  
        @endforeach
        <div class="pagination-menu">
            {{ $videos->links() }}
        </div>
    @endisset
@endsection