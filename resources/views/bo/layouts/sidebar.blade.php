<div class="left main-sidebar">
    <div class="sidebar-inner leftscroll">
        <div id="sidebar-menu">
            <ul>

                <li class="submenu">
                    <a href="{{ route('bo.theme.index') }}" class="{{ Route::is('bo.theme.index')? 'active': '' }}"><i class="fa fa-fw fa-clone"></i><span> @lang('messages.themes') </span> </a>
                </li>

                <li class="submenu">
                    <a href="{{ route('bo.video.index') }}" class="{{ Route::is('bo.video.index', 'bo.video.show')? 'active': '' }}"><i class="fa fa-fw fa-file-video-o"></i><span> @lang('messages.videos') </span> </a>
                </li>

                <li class="submenu">
                    <a href="{{ route('bo.barker.index') }}" class="{{ Route::is('bo.barker.index')? 'active': '' }}"><i class="fa fa-fw fa-file-video-o"></i><span> @lang('messages.barker_configuration') </span> </a>
                </li>

                <li class="submenu">
                    <a href="{{ route('bo.user.index') }}" class="{{ Route::is('bo.user.index')? 'active': '' }}"><i class="fa fa-fw fa-users"></i><span> @lang('messages.users') </span> </a>
                </li>

                <li class="submenu">
                    <a href="{{ route('bo.parameters.index') }}" class="{{ Route::is('bo.parameters.index')? 'active': '' }}"><i class="fa fa-fw fa-cogs"></i><span> @lang('messages.parameters') </span> </a>
                </li>
                <li class="submenu">
                    <a href="{{ route('index') }}"><i class="fa fa-angle-double-left"></i><span> @lang('messages.title.index') </span> </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
