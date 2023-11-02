@extends('front.channel.manage.content.channel-content')

@section('head-title')
  {{ __('Channel content') . ": " . __('Playlists') }}
@endsection

@section('playlists')
  @if (auth()->user()->playlists->count() > 0) 
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">@sortablelink('title', 'Playlist')</th>
            <th scope="col">{{ __('Visibility') }}</th>
            <th scope="col">@sortablelink('created_at', __('Creation date'))</th>
            <th scope="col">{{ __("Actions") }}</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach ($playlists as $playlist)
          <tr>
            <td style="display: flex;">
              <a href="{{ route('show-current-playlist', $playlist->slug) }}">
                <img src="/images/playlists/{{ $playlist->thumbnail }}" width="100" alt="Lipsa imagine de tip thumbnail">
              </a>
              <h6 style="padding-left: inherit;">{{ $playlist->title }}</h6>
            </td>
            <td class="text-center">{{ $playlist->published == 1 ? __('Published') : __('Unpublished') }}</td>
            <td class="text-center">{{ $playlist->created_at->format('d.m.Y') }}</td>
            <td>
              <div class="btn-group" role="group" aria-label="Action buttons">
                  <a href="{{ route('channel-content-edit-playlist-form', $playlist->id) }}"><button type="button" class="btn btn-primary btn-sm">{{ __('Edit') }}</button></a>
                  <form id="delete-playlist-form-with-id-{{ $playlist->id }}" action="{{ route('channel-content-delete-playlist', $playlist->id) }}" method="POST">
                    @csrf
                    @method('delete')
                  </form>
                    <button type="button" class="btn btn-danger btn-sm" onclick="
                    if(confirm('{{ __('Are you sure you want to delete the playlist:') }} {{ $playlist->title }}?')) {
                        document.getElementById('delete-playlist-form-with-id-' + {{ $playlist->id }}).submit();
                    }
                    ">{{ __('Delete') }}
                  </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
    {{ $playlists->links() }}    
  @else
    <h3>{{ __("You haven't created any playlists") }}.</h3>
  @endif
@endsection

@section('image-preview-script')
  @include('front.scripts.image-preview-script')
@endsection