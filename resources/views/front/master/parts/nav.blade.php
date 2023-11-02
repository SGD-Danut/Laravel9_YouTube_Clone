<!--    nav      -->
<section class="left-nav" id="navbar">
  <nav class="nav_container">
    <div>
      <a href="{{ route('home') }}" class="nav_link nav_logo ">
        <i class="fa-solid fa-bars nav_icon"></i>
        <span class="logo_name">
          <i class="fab fa-youtube"></i>
          YouTube
        </span>
      </a>
      <div class="nav_list">
        <div class="nav_items navtop">
          <a href="{{ route('home') }}" class="nav_link navtop {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa fa-house nav_icon"></i>
            <span class="nav_name">{{ __('Home') }}</span>
          </a>
          @auth
            @if (auth()->user()->channel_id != null)
              <a href="{{ route('show-channel-home', auth()->user()->channel->slug) }}" class="nav_link navtop {{ request()->routeIs('show-channel-home') ? 'active' : '' }}">
                <i class="fa-solid fa-users nav_icon"></i>
                <span class="nav_name">{{ __('Channel') }}</span>
              </a>
            @endif
          @endauth
          <a href="{{ route('library') }}" class="nav_link navtop {{ request()->routeIs('library') ? 'active' : '' }}">
            <i class="fa-solid fa-circle-play nav_icon"></i>
            <span class="nav_name">{{ __('Library') }}</span>
          </a>
          <a href="{{ route('history') }}" class="nav_link navtop {{ request()->routeIs('history') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left nav_icon"></i>
            <span class="nav_name">{{ __('History') }}</span>
          </a>
          <a href="{{ route('liked-videos') }}" class="nav_link navtop {{ request()->routeIs('liked-videos') ? 'active' : '' }}">
            <i class="fa-solid fa-thumbs-up nav_icon"></i>
            <span class="nav_name">{{ __('Liked videos') }}</span>
          </a>
          <div class="nav_dropdown">
            <a href="#" class="nav_link">
              <i class="fa-solid fa-language nav_icon"></i>
              <span class="nav_name">{{ __('Language') }}</span>
            </a>
            <div class="nav_dropdown-collapse">
              <div class="nav_dropdown-content">
                <a href="{{ route('set-language', ['locale' => 'en']) }}" class="nav_dropdown-item">English</a>
                <a href="{{ route('set-language', ['locale' => 'ro']) }}" class="nav_dropdown-item">Română</a>
              </div>
            </div>
          </div>
        </div>
        <div class="nav_items subscribe-container">
          @if (Auth::check())
            @if (Auth::user()->subscribedChannels->count() > 0)
                <h3 class="nav_subititle">{{ __('Subscriptions') }}</h3>
            @endif
            @foreach (Auth::user()->subscribedChannels as $channel)
              <a href="{{ route('show-channel-home', $channel->slug) }}" class="nav_link">
                <img class="subscribe" src="\images\avatars\{{ $channel->avatar }}" alt="">
                <span class="nav_name">{{ $channel->title }}</span>
              </a>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </nav>
</section>
<!--    nav      -->