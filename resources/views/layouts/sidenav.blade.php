@show()
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        @php
            $cURI = Request::segment(count(Request::segments()));
        @endphp
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="{{asset('storage/img/brand/diaspora.png')}}" class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'admin') {!! "active" !!} @endif" href="{{route('dashboard')}}">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Главная</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'ads') {!! "active" !!} @endif" href="{{route('ads')}}">
                            <i class="ni ni-collection text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Посты</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'inquiries') {!! "active" !!} @endif" href="{{route('inquiries')}}">
                            <i class="ni ni-bell-55 text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Запросы</span>
                            <span style="margin-left: 20px;" class="badge badge-md badge-circle badge-floating badge-danger border-white">{{App\Models\RequestModel::where('status', 0)->count() === 0?'':App\Models\RequestModel::where('status', 0)->count()}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'users') {!! "active" !!} @endif" href="{{route('users')}}">
                            <i class="ni ni-single-02 text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Пользователи</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'countries') {!! "active" !!} @endif" href="{{route('countries')}}">
                            <i class="ni ni-world text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Страны</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'cities') {!! "active" !!} @endif" href="{{route('cities')}}">
                            <i class="ni ni-building text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Города</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($cURI === 'categories') {!! "active" !!} @endif" href="{{route('categories')}}">
                            <i class="ni ni-briefcase-24 text-primary"></i>
                            <span class="nav-link-text" id="menu-text">Категории</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="submitLogout()">
                            <i class="ni ni-button-power text-pink"></i>
                            <span class="nav-link-text" >Выход</span>
                        </a>
                    </li>
                </ul>
                <form style="position: fixed;" method="POST" id="logoutForm" action="{{route('logout')}}">
                    @csrf
                    <script>
                        function submitLogout(){
                            document.getElementById('logoutForm').submit();
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</nav>



