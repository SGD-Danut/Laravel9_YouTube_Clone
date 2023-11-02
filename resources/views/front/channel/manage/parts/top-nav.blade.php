<div class="container fixed-top">
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}"><img src="/images/youtube-logo.png" width="100" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
          </li>
          @if (auth()->user()->channel_id != NULL)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('show-channel-home', auth()->user()->channel->slug) }}">{{ __('Your channel') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('customize-channel-layout') }}">{{ __('Customization') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('channel-content') }}">{{ __('Content') }}</a>
            </li>
          @endif
        </ul>
      </div>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ strtoupper(app()->getLocale()) }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('set-language', ['locale' => 'en']) }}">English</a></li>
            <li><a class="dropdown-item" href="{{ route('set-language', ['locale' => 'ro']) }}">Română</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                                          this.closest('form').submit();">
                          {{ __('Log Out') }}
                      </a>
                    </li>
                </form>
            </ul>
        </li>
      </ul>
    </div>
  </nav>
</div>