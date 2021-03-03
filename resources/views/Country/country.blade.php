@extends('ParentHTML.ParentHTML')

@section('page-title') Страны @endsection

@section('page-body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Страны</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Страна</th>
                            <th scope="col" class="sort" data-sort="budget">Кол-во Объявлений</th>
                            <th style="color: #5e72e4;" scope="col" class="sort" data-sort="status">Активный</th>
                            <th style="color: red;" scope="col">Не активный</th>
{{--                            <th scope="col">Статус</th>--}}
                            <th scope="col">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#InsertCountryModal">Добавить страну</button>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($countries as $country)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{$country->country_name}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="budget">
                                    254
                                </td>
                                <td>
                              <span class="badge badge-dot mr-4">
                                <span class="status">200</span>
                              </span>
                                </td>
                                <td class="budget">
                                    254
                                </td>
{{--                                <td>--}}
{{--                                    <form method="POST" action="{{route('updateStatusCategory', $country->id)}}">--}}
{{--                                        @csrf--}}
{{--                                        <label class="custom-toggle">--}}
{{--                                            <button style="outline: none; border: none;" type="submit">--}}
{{--                                                <input id="status-checker" type="checkbox" @if($country->status === 1) {!! 'checked' !!} @endif>--}}
{{--                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>--}}
{{--                                            </button>--}}
{{--                                        </label>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="InsertCountryModal" tabindex="-1" role="dialog" aria-labelledby="InsertCountryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="InsertCountryModalLabel">Заполните</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{route('storeCountry')}}">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" name="country_name" id="country_name" class="form-control" placeholder="Название Страны">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Назад</button>
                                    <button type="submit" class="btn btn-primary">Добавить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $countries->links("pagination::bootstrap-4") }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
