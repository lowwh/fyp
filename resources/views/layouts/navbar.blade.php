<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Welcome</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="home" class="nav-link">Home</a>
        </li>
        <li class="nav-item"><a href="searchresult" class="nav-link">Search</a></li>
    </ul>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif
        @else
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ Auth::user()->unreadNotifications->count() }}
                        Notifications</span>
                    <div class="dropdown-divider"></div>
                    @foreach(Auth::user()->unreadNotifications as $notification)
                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> New message from
                            {{ $notification->data['sender_name'] ?? 'Unknown' }}
                            <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <!-- Bidding  Notifications Dropdown Menu for freelancer user-->
            @can('isFreelancer')


                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-gavel"></i> <!-- Icon for bidding notifications -->


                        <span
                            class="badge badge-info navbar-badge">{{ Auth::user()->unreadBiddingNotifications()->count() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ Auth::user()->unreadBiddingNotifications()->count() }}
                            Bidding Notifications</span>
                        <div class="dropdown-divider"></div>
                        @foreach(Auth::user()->unreadBiddingNotifications as $notification)
                            <a href="{{ route('bidding.notifications.markAsRead', $notification->id) }}" class="dropdown-item">
                                <div class="notification-text">
                                    <i class="fas fa-gavel mr-2"></i>
                                    <div class="notification-details">
                                        <div class="notification-main">
                                            New bid placed by on your gig ID {{ $notification->data['service_id'] ?? 'Unknown' }}
                                        </div>
                                    </div>
                                </div>
                                <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @endforeach



                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Bidding Notifications</a>
                    </div>
                </li>

            @endcan


            <!-- Bidding success Notifications Dropdown Menu for normal user-->
            @can('isUser')

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-gavel"></i> <!-- Icon for bidding notifications -->

                        <span
                            class="badge badge-info navbar-badge">{{ Auth::user()->unreadBiddingSuccessNotifications()->count() }}</span>

                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span
                            class="dropdown-item dropdown-header">{{ Auth::user()->unreadBiddingSuccessNotifications()->count() }}
                            Bidding Notifications</span>
                        <div class="dropdown-divider"></div>

                        <!-- Bidding Success notification Dropdown Menu-->
                        @foreach(Auth::user()->unreadBiddingSuccessNotifications as $notification)
                            <a href="{{ route('bidding.notifications.markAsReadUser', $notification->id) }}" class="dropdown-item">
                                <div class="notification-text">
                                    <i class="fas fa-gavel mr-2"></i>
                                    <div class="notification-details">
                                        <div class="notification-main">
                                            Your bid has been confirmed on gig ID
                                            {{ $notification->data['service_id'] ?? 'Unknown' }}
                                        </div>
                                    </div>
                                </div>
                                <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Bidding Notifications</a>
                    </div>
                </li>
            @endcan



            <!-- User Account Dropdown Menu -->
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>

<style>
    .dropdown-item {
        white-space: normal;
    }

    .dropdown-item .notification-text {
        display: flex;
        align-items: center;
    }

    .dropdown-item .notification-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .dropdown-item .notification-main {
        flex-grow: 1;
        margin-left: 10px;
    }
</style>