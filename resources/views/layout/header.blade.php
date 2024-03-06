<header>
    <div>
        <h1>Todo list App</h1>
    </div>
    <div class="header__infos">
        @auth

        <div>
            @if(Auth::user()->role == "admin")
            <span>ADMIN: </span>
            @endif
            <a class="link" href="{{ route('profile.getProfile', ['id' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a>
        </div>
            <div>
                <form method="POST" action="{{ route('login.logout') }}">
                    @method('delete')
                    @csrf
                    <button class="btn">Se deconnecter</button>
                </form>
            </div>
        @endauth
        
        @guest
            <a class="btn" href="{{ route('login.index') }}">Se connecter</a>
        @endguest
    </div>
</header>
