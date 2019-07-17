<header style="background: #2fb7aa; height: 40px;">
    <style>
        header .src-area {
            width: 20%;
            height: 40px;
        }
    </style>
    <div class="container-fluid position-relative no-side-padding">

{{--        <h4><a href="#" class="logo"><strong style="color: #007aff;">Blog</strong></a></h4>--}}
        <a style="margin-top: 9px;" href="{{route('home')}}" class="logo"><img src="{{asset('assets/frontend/images/Blogging.png')}}" alt="Logo Image"></a>

        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

        <ul style="color: #fff; margin-top: -10px;" class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{route('home')}}">Home</a></li>
            <li><a href="{{route('posts.index')}}">All Posts</a></li>
            <li><a href="{{route('categories.posts')}}">All Categories</a></li>
            @guest
                <li><a href="{{route('login')}}">Login</a> <a href="{{route('register')}}">Register</a> </li>
            @else
                @if(Auth::user()->role->id == 1)
                    <li><a target="_blank" href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li><a href="{{route('logout')}}">Logout</a></li>
                @endif
                    @if(Auth::user()->role->id == 2)
                        <li><a target="_blank" href="{{route('author.dashboard')}}">Dashboard</a></li>
                        <li><a href="{{route('logout')}}">Logout</a></li>
                    @endif
            @endguest
        </ul><!-- main-menu -->

        <div style="background: #dcd6affa;" class="src-area">
            <form method="GET" action="{{route('search')}}">
                <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                <input class="src-input" value="{{isset($query) ? $query : ''}}" name="query" type="text" placeholder="Type of search">
            </form>
        </div>

    </div><!-- conatiner -->
</header>
