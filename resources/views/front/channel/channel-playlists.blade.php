@extends('front.channel.master.channel')

@if ($playlistsOfTheChannel->count() > 0)   
  @section('playlists')
    <main>
      <section class="video_content grid">
        @foreach ($playlistsOfTheChannel as $playlist)
        <div class="video_items">
          <a href="{{ route('show-current-playlist', $playlist->slug) }}">
            <div class="video-thumbnail">
              <img src="/images/playlists/{{ $playlist->thumbnail }}" alt="Playlist thumbnail" style="max-height: 120px; max-width:fit-content"> 
            </div>
          </a>
          <div class="details flex">
            <div class="heading">
              <p>{{ $playlist->title }}</p>
              <span>{{ $playlist->created_at->format('d.m.Y') }}</span>
            </div>
          </div>
        </div>
        @endforeach
      </section>
      {{ $playlistsOfTheChannel->links() }}
    </main>
  @endsection
@else
  @section('playlists')
    <h5 class="py-5 text-center container">{{ __('This channel does not have any playlists to display!') }}</h5>
  @endsection
@endif