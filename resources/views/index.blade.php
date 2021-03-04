@extends('ParentHTML.ParentHTML')

@section('page-title') Панель Администратора | Главная @endsection

@section('page-body')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Топ посты</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('ads')}}" class="btn btn-sm btn-primary">Посмотреть все</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: left;">ОПИСАНИЕ</th>
                            <th scope="col">ГОРОД</th>
                            <th scope="col">ФОТО</th>
                            <th scope="col" >Лайки</th>
                            <th scope="col" >Просмотрели</th>
                            <th scope="col" >ПОСМОТРЕТЬ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <th scope="row" style="text-align: left;">
                                    {{ $request->description }}
                                </th>
                                <td>
                                    {{ $request->city() }}
                                </td>
                                <td>
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ImageModal_{{$request->id}}"></button>
                                    <!-- Modal Box for image -->
                                    <div class="modal fade" id="ImageModal_{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="ImageModalCenterTitle_{{$request->id}}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ImageModalCenterTitle_{{$request->id}}"> Фотография поста №{{$request->id}}</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img class="img-thumbnail" src="/{{$request->photo_path}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $request->likes }}
                                </td>
                                <td>
                                    {{ $request->seen }}
                                </td>
                                <td>
{{--                                    <button class="btn btn-sm btn-primary" type="button">Посмотреть</button>--}}
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#PostModal_{{$request->id}}">Посмотреть</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="PostModal_{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="PostModalCenterTitle_{{$request->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="PostModalCenterTitle_{{$request->id}}"> Пост №{{$request->id}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row h-auto d-block">
{{--                                                <h3 class="modal-title text-center mt-3 mb-3">Данные пользователя №{{ $request->id }}</h3>--}}
                                                <div class="col-lg-12 d-flex flex-wrap justify-content-center align-items-center">
                                                    <div class="col-lg-6 d-inline-flex flex-wrap">
                                                        <div class="col-sm-12 text-wrap">
                                                            Описание: {{ $request->description }}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Город: {{ $request->city() }}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Категория: {{ $request->category() }}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Кол-во просмотров: {{ $request->seen }}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Понравилось: {{ $request->likes }}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Дата поста: {{ $request->created_at }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 d-inline-flex flex-wrap">
                                                        <img class="img-thumbnail" src="/{{$request->photo_path}}">
                                                    </div>
                                                </div>
                                                <h3 class="modal-title text-center mt-3 mb-3">Связаться: </h3>
                                                <div class="col-lg-12 d-flex flex-wrap justify-content-center align-items-center">
                                                    <div class="col-lg-12 d-inline-flex flex-wrap">
                                                        <div class="col-sm-12">
                                                            ФИО: {{$request->user()->name . $request->user()->surname}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            WhatsApp: {{$request->user()->whatsapp}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Telegram: {{$request->user()->telegram}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            IMO: {{$request->user()->IMO}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Viber: {{$request->user()->viber}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Instagram: {{$request->user()->instagram}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Facebook: {{$request->user()->facebook}}
                                                        </div>
                                                        <div class="col-sm-12">
                                                            Twitter: {{$request->user()->twitter}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Города</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('cities')}}" class="btn btn-sm btn-primary">Посмотреть все</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="height: 448px;">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Город</th>
                            <th scope="col">Пользователи</th>
                            <th scope="col">Объявлений</th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($city_user_request as $cur)
                            <tr>
                                <th scope="row">
                                    {{ $cur->CITY_NAME }}
                                </th>
                                <td>
                                    {{ $cur->Q_USERS }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{ $cur->Q_REQUESTS }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
