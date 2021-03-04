@extends('ParentHTML.ParentHTML')

@section('page-title') Посты @endsection

@section('page-body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Посты</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name" style="text-align: left;">Ф.И.О</th>
                            <th scope="col" class="sort" data-sort="status">Описание</th>
                            <th scope="col">Город</th>
                            <th scope="col" class="sort" data-sort="completion">Фото</th>
                            <th scope="col">Статус</th>
                            <th scope="col" ></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($requests as $request)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{$request->user()->surname . " " . $request->user()->name}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                          <span class="badge badge-dot mr-4">
                            <span class="status">{{$request->description}}</span>
                          </span>
                                </td>
                                <td class="budget">
                                    {{$request->city()}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
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
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" action="{{route('updatePostStatus', $request->id)}}">
                                        @csrf
                                        <label class="custom-toggle">
                                            <button style="outline: none; border: none;" type="submit">
                                                <input id="status-checker" type="checkbox" @if($request->status === 1) {!! 'checked' !!} @endif>
                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                            </button>
                                        </label>
                                    </form>

                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#PostModal_{{$request->id}}">Посмотреть</button>
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="..." class="table-responsive" style="flex-wrap: wrap;">
                        {{$requests->links("pagination::bootstrap-4")}}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
