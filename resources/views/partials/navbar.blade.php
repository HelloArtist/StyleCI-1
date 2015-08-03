<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">StyleCI</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            @if($current_user)
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('account') }}">{{ $current_user->name }}</a></li>
                <li><a href="{{ route('auth_logout') }}" data-method="POST">Logout <span class="sr-only">(current)</span></a></li>
            </ul>
            @else
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('auth_login') }}" data-method="POST">Login <span class="sr-only">(current)</span></a></li>
            </ul>
            @endif
        </div>
    </div>
</nav>
