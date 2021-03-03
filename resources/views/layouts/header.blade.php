@show()
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">
                        @php
                            $lastURI = Request::segment(count(Request::segments()));
                            $lastURIName = "";
                            switch ($lastURI){
                                case 'admin': echo "Главня"; $lastURIName = "Главная"; break;
                                case 'ads': echo "Посты"; $lastURIName = "Посты"; break;
                                case 'inquiries': echo "Запросы"; $lastURIName = "Запросы"; break;
                                case 'users': echo "Пользователи"; $lastURIName = "Пользователи"; break;
                                case 'countries': echo "Страны"; $lastURIName = "Страны"; break;
                                case 'cities': echo "Города"; $lastURIName = "Города"; break;
                                case 'categories': echo "Категории"; $lastURIName = "Категории"; break;
                            }
                        @endphp
                    </h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            @for($i = 0; $i < count(Request::segments()) - 1; $i++)
                                <li class="breadcrumb-item">{{Request::segments()[$i]}}</li>
                            @endfor

                            <li class="breadcrumb-item active" aria-current="page">{{$lastURIName}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <!--  <a href="#" class="btn btn-sm btn-neutral">New</a>
                     <a href="#" class="btn btn-sm btn-neutral">Filters</a> -->
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Объвления</h5>
                                    <span class="h2 font-weight-bold mb-0">350</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="ni ni-collection"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm" style="margin-top: 0.7rem !important;">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">С прошлого месяца</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Пользователи</h5>
                                    <span class="h2 font-weight-bold mb-0">{{\App\Models\User::count()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                        <i class="ni ni-single-02"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm" style="margin-top: 0.7rem !important;">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">С прошлого месяца</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Городов</h5>
                                    <span class="h2 font-weight-bold mb-0">{{\App\Models\CityModel::count()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="ni ni-world"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">СТРАНЫ</h5>
                                    <span class="h2 font-weight-bold mb-0">{{\App\Models\CountryModel::count()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                        <img src="{{asset('storage/img/icons/common/Vector.png')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
