@extends('ParentHTML.ParentHTML')

@section('page-title') Запросы @endsection

@section('page-body')

    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Запросы на Объявлений</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name" style="text-align: left;">ФИО</th>
                            <th scope="col" class="sort" data-sort="status">Описание</th>
                            <th scope="col">Город</th>
                            <th scope="col" class="sort" data-sort="completion">Фото</th>
                            <th scope="col">Статус</th>

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
                                                        <h5 class="modal-title" id="ImageModalCenterTitle_{{$request->id}}"> Фотография зпроса №{{$request->id}}</h5>

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
                                    <div class="d-flex align-items-center">
                                        <form method="POST" action="{{route('AcceptOrRejectPost', $request->id)}}">
                                            @csrf
                                            <div class="form-group m-1">
                                                <input type="hidden" name="operation" value="accept">
                                                <button class="ni ni-check-bold btn btn-sm btn-primary" type="submit"></button>
                                            </div>
                                        </form>
                                        <form method="POST" action="{{route('AcceptOrRejectPost', $request->id)}}">
                                            @csrf
                                            <div class="form-group m-1">
                                                <input type="hidden" name="operation" value="reject">
                                                <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="submit"></button>
                                            </div>
                                        </form>
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
                        {{ $requests->links("pagination::bootstrap-4") }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
