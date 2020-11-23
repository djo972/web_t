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
{{--        @foreach($themes as $theme)--}}
{{--                <li>--}}
{{--                    <a href="{{ route('index.video',$theme->id) }}"  >{{ $theme->name }}--}}
{{--                        <span><img src="{{ asset('/uploads/images/'. $theme->icon) }}"/></span>--}}
{{--                    </a></li>--}}
{{--            @endforeach--}}
            @foreach($themes as $theme)
                <li>
                    <a href="{{ route('index.video',$theme->id) }}" >
                        <p>{{ $theme->name }}</p>
                        <img src="{{ asset('/uploads/images/'. $theme->icon) }}"/>
                    </a></li>
            @endforeach
        </ul>
    </div>
</div>
