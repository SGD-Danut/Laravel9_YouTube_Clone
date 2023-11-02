@extends('front.master.master-page')

@section('head-title')
    {{ __('History') }}
@endsection

@section('history-page-style')
    <link rel="stylesheet" href="/css/history-page.css">
@endsection

@section('content')
    @if ($historyFromCurrentUser->count() > 0)
        <h2>{{ __('History') }}</h2>
        @inject('video', 'App\Models\Video')
        @foreach ($historyFromCurrentUser as $history)
            {{-- Metoda alternativa: --}}
            {{-- <h2>{{ \App\Models\Video::find($history->video_id)->title }}</h2>
            <img width="150" src="\images\thumbnails\{{ \App\Models\Video::find($history->video_id)->thumbnail }}" alt=""> --}}
            {{-- <h2>{{ $video::find($history->video_id)->title }}</h2>
            <img width="246" src="\images\thumbnails\{{ $video::find($history->video_id)->thumbnail }}" alt=""> --}}
            
            {{-- <div class="image-container">
            <img src="\images\thumbnails\{{ $video::find($history->video_id)->thumbnail }}" alt="Video image" width="246" height="auto">
                <div class="caption">
                    <h2>{{ $video::find($history->video_id)->title }}</h2>
                    <p>{{ $video::find($history->video_id)->description }}</p>
                </div>
            </div> --}}
            <div class="image-container">
                <a href="{{ route('show-current-video', $video::find($history->video_id)->slug) }}">
                    <img src="\images\thumbnails\{{ $video::find($history->video_id)->thumbnail }}" alt="Video image" width="246" height="auto">
                </a>
                <div class="caption">
                    <h2>{{ $video::find($history->video_id)->title }}
                        <form action="{{ route('delete-video-from-history', $history->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="delete-video-from-history-button">X</button>
                        </form>        
                    </h2>
                    <p>{!! substr($video::find($history->video_id)->description, 0, 61) !!}{{ strlen($video::find($history->video_id)->description) > 61 ? "..." : ""}}</p>
                    <p class="viewed-on"><h3>{{ __('Accessed:') }}</h3> {{ $history->created_at->diffForHumans() }}</p>
                </div>
            </div> 
        @endforeach
        <div class="pagination-menu">
        {{ $historyFromCurrentUser->links() }}
        </div>  
    @else
        <h2>{{ __("You don't have any videos in your history") }}!</h2>
    @endif
@endsection