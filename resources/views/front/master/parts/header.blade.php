<!--    header      -->
<header class="header">
  <div class="header_container">
    <div class="none"></div>
    <form action="{{ route('searched-videos') }}" class="d-flex" role="search">
      @csrf
      <div class="search">
      <input name="searchVideoTerm" type="search" placeholder="{{ __('Search') }}..." aria-label="Search">
      <button style="cursor: pointer;" class="fa-solid fa-magnifying-glass search-video-button" type="submit"></button>
      </div>
    </form>
    <div class="user">
      <div class="icon">
        <a href="{{ route('show-new-video-form') }}" title="{{ __('Upload a video') }}"><i class="fa-stack fa-solid fa-video"></i></a>
        @auth
          <a href="{{ route('user-notifications') }}" title="{{ __('Notifications') }}">
            @if (Auth::user()->notifications->count() > 0)
              <span class="fa-stack fa-2x has-badge" data-count="{{ Auth::user()->notifications->count() }}">
                <i class="fa-stack fa-solid fa-bell"></i>
              </span>
            @else
              <i class="fa-stack fa-solid fa-bell"></i>
            @endif
          </a>
        @endauth
      </div>
      <style>
        .fa-stack[data-count]:after{
          position: absolute;
          right: 65%;
          top: 20%;
          content: attr(data-count);
          font-size: 30%;
          padding: 0.6em;
          border-radius: 999px;
          line-height: .75em;
          color: white;
          background: rgba(255,0,0,.85);
          text-align: center;
          min-width: 2em;
          font-weight: bold;
        }
      </style>
      @if (Auth::check() && auth()->user()->channel_id != NULL)
        <a href="{{ route('dashboard') }}">
          <div class="img">
            <img src="/images/avatars/{{ Auth::check() ? auth()->user()->channel->avatar : 'default-avatar.png' }}" alt="" class="avatar-image small-avatar">
          </div>
        </a>
      @else
        <a href="{{ route('dashboard') }}">
          <div class="img">
            <img src="/images/avatars/default-avatar.png" alt="" class="avatar-image">
          </div>
        </a>
      @endif
    </div>
    <div class="toggle">
      <i class="fa-solid fa-bars" id="header-toggle"></i>
    </div>
  </div>
</header>
<!--    header      -->