<div class="navbar navbar-expand-md header_navbar">
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
    <div id="logo" class="navbar-brand"><a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"></a></div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        <span class="navbar-toggler-icon"></span>
        <span class="navbar-toggler-icon"></span>
    </button>
    <div  id="navbarNav" class="collapse navbar-collapse">
        <ul id="listLinks" class="navbar-nav">
            {!! $menu_themes !!}
        </ul>
    </div>
</div>
