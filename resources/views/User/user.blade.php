@extends('ParentHTML.ParentHTML')

@section('page-title') Пользователи @endsection

@section('page-body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Пользователи</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">ФИО</th>
                            <th scope="col" class="sort" data-sort="budget">Откуда</th>
                            <th scope="col" class="sort" data-sort="status">Телефон</th>
                            <th scope="col">Местоположение</th>
                            <th scope="col" class="sort" data-sort="completion">Фото</th>
                            <th scope="col">Статус</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$user->surname . " " . $user->name}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{$user->country()}}
                                    </td>
                                    <td>
                                      <span class="badge badge-dot mr-4">
                                        <span class="status">{{$user->phone_number}}</span>
                                      </span>
                                    </td>
                                    <td class="budget">
                                        {{$user->city()}}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="fas fa-image btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ImageModal_{{$user->id}}"></button>
                                            <!-- Modal Box for image -->
                                            <div class="modal fade" id="ImageModal_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="ImageModalCenterTitle_{{$user->id}}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ImageModalCenterTitle_{{$user->id}}"> Фотография пользователя {{$user->name}}</h5>

                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img class="img-thumbnail" src="/{{$user->photo_path}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <form method="POST" action="{{route('updateStatus', $user->id)}}">
                                            @csrf
                                            <label class="custom-toggle">
                                                <button style="outline: none; border: none;" type="submit">
                                                <input id="status-checker" type="checkbox" @if($user->status === 1) {!! 'checked' !!} @endif>
                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                </button>
                                            </label>
                                        </form>

                                        <!-- <div class="d-flex align-items-center">
                                          <div class="btn btn-sm btn-primary">Активный</div>
                                           <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button">Заблокировать</button>
                                           <div>
                                          </div>
                                        </div> -->
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <button class="dropdown-item btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ProfileModal_{{$user->id}}">Профиль</button>
                                                <button class="dropdown-item btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#UserRequestsModal_{{$user->id}}">Объявлений</button>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="ProfileModal_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="ProfileModalCenterTitle_{{$user->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ProfileModalCenterTitle_{{$user->id}}"> Пользователь {{$user->name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row h-auto d-block">
                                                            <h3 class="modal-title text-center mt-3 mb-3">Персональные данные</h3>
                                                            <div class="col-lg-12 d-flex flex-wrap justify-content-center align-items-center">
                                                                <div class="col-lg-6 d-inline-flex flex-wrap">
                                                                    <div class="col-sm-12">
                                                                        Имя: {{$user->name}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Фамилия: {{$user->surname}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Username: {{$user->username}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        email: {{$user->email}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Пол: {{$user->gender}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Номер телефона: {{$user->phone_number}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        День рождение: {{$user->birthday}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Cемейное положение: {{$user->marital_status}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Родной город: {{$user->country()}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        В данный момент живет в: {{$user->city()}}
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 d-inline-flex flex-wrap">
                                                                    <img class="img-thumbnail" src="/{{$user->photo_path}}">
                                                                </div>
                                                            </div>
                                                            <h3 class="modal-title text-center mt-3 mb-3">Социальные сети</h3>
                                                            <div class="col-lg-12 d-flex flex-wrap justify-content-center align-items-center">
                                                                <div class="col-lg-12 d-inline-flex flex-wrap">
                                                                    <div class="col-sm-12">
                                                                        WhatsApp: {{$user->whatsapp}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Telegram: {{$user->telegram}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        IMO: {{$user->IMO}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Viber: {{$user->viber}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Instagram: {{$user->instagram}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Facebook: {{$user->facebook}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        Twitter: {{$user->twitter}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="UserRequestsModal_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="UserRequestsModalLabel_{{$user->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="UserRequestsModalLabe_{{$user->id}}"> Пользователь {{$user->name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row h-auto d-block">
                                                            <h3 class="modal-title text-center mt-3 mb-3">Посты от {{ $user->name }}</h3>
                                                            <div class="col-lg-12 d-flex flex-wrap justify-content-center align-items-center">

                                                                @if(count($user->requests()) != 0)
                                                                    <div class="col-sm-12 d-flex justify-content-center align-items-center flex-wrap">
                                                                        @foreach($user->requests() as $post)
                                                                            <div class="card m-3" style="width: 18rem;">
                                                                                <img class="card-img-top" src="/{{$post->photo_path}}" alt="Card image cap">
                                                                                <div class="card-body">
                                                                                    <p class="card-text text-wrap">{{$post->description}}</p>
                                                                                </div>
                                                                                <div class="card-footer">
                                                                                    <p class="card-text text-wrap">Категория: {{$post->category()}}</p>
                                                                                    <p class="card-text text-wrap">Просмотрено: {{$post->city()}}</p>
                                                                                    <p class="card-text text-wrap">Просмотрено: {{$post->seen}}</p>
                                                                                    <p class="card-text text-wrap">Понравилось: {{$post->likes}}</p>
                                                                                    <p class="card-text text-wrap">Дата поста: {{$post->created_at}}</p>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <div class="secondary">У этого пользователя нет постов.</div>
                                                                @endif
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
                        {{ $users->links("pagination::bootstrap-4") }}

                    </nav>
                </div>
            </div>
        </div>
    </div>


@endsection
