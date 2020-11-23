<div class="headerbar">

    <!-- LOGO -->
    <div class="headerbar-left">
        <a href="{{ route('bo.theme.index') }}" class="logo"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"></a>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item notif align-top">
                <div class=" ">

                    @if(auth()->check())
                    <!-- item-->
                    <a href="{{ route('logout') }}" class="notify-item">
                        <span>@lang('auth.logout')</span> <i class="fa fa-power-off"></i>
                    </a>
                    @endif
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </li>
        </ul>

    </nav>

</div>