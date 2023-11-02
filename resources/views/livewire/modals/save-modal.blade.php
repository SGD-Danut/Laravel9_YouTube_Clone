<!-- Save Modal start: -->
<div wire:ignore.self id="saveModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close closeSaveModal" style="color: white; float: right; font-size: 28px; font-weight: bold; --darkreader-inline-color:#e8e6e3;">&times;</span>
      @if (auth()->check())
        <h2>{{ __('Save your favorite video in a list created by you') }}: 🙂</h2>
      @else
        <h2>{{ __('Do you want to watch the video again later?') }} 🤔</h2>
      @endif
    </div>
    <div class="modal-body">
      @if (auth()->check())
        <h2>{{ __('Add the video to a playlist') }}! 🙂</h2>
        <form>
            @foreach ($playlists as $playlist)
            <div class="mb-3">
                <input class="form-check-input" type="checkbox" value="{{ $playlist->id }}" id="check-{{ $playlist->id }}" wire:model="selectedPlaylists" wire:click="setPlaylists">
                <label class="form-check-label" for="check-{{ $playlist->id }}">
                    {{ $playlist->title }}
                </label>
            </div>    
            @endforeach
        </form>
        @if (session()->has('setPlaylistsSuccessMessage'))
            <h5 style="color: rgb(102, 69, 201)">{{ session('setPlaylistsSuccessMessage') }}</h5>
        @endif
        @if (session()->has('setPlaylistsErrorMessage'))
            <h5 class="alert alert-danger">{{ session('setPlaylistsErrorMessage') }}</h5>
        @endif      
        <h2>{{ __('Add a playlist') }}! 🙂</h2>
        @if (session()->has('addPlaylistSuccessMessage'))
            <h5 style="color: rgb(102, 69, 201)">{{ session('addPlaylistSuccessMessage') }}</h5>
        @endif
        @if (session()->has('addPlaylistErrorMessage'))
            <h5 class="alert alert-danger">{{ session('addPlaylistErrorMessage') }}</h5>
        @endif
        <form wire:submit.prevent='addPlaylist'>
            <label for="InputPlaylistTitle" class="form-label">{{ __('Title') }}</label>
            <input type="text" wire:model='title' class="inputPlaylistTitle" id="InputPlaylistTitle" aria-describedby="titleHelp">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            <button type="submit" class="addPlaylistButton">{{ __('Add') }}</button>
        </form>
      @else
          <h2>{{ __('Log in to add this video to a playlist') }}.</h2>
          <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
      @endif
    </div>
    <div class="modal-footer">
      <h3> </h3>
    </div>
  </div>
</div>
<!-- Save Modal end. -->