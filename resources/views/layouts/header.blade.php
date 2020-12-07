<div class="navbar navbar-expand-md header_navbar">
    <div id="logo" class="navbar-brand"><a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"></a></div>
    @if(auth()->check())
        <a href="{{ route('logout') }}" class="logout">
            <i class="fa fa-power-off"></i>
        </a>
        @if (Auth::user()->type == 'admin' or 'superadmin')
            <a href="/bo/themes" class="logout">
                <i class="fa fa-wrench"></i>
            </a>
        @endif
    @endif
</div>