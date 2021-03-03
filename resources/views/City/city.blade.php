@extends('ParentHTML.ParentHTML')

@section('page-title') Города @endsection

@section('page-body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Города</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Город</th>
                            <th scope="col" class="sort" data-sort="budget">Количество Объявлений</th>
                            <th style="color: #5e72e4;" scope="col" class="sort" data-sort="status">Активный</th>
                            <th style="color: red;" scope="col">Не активный</th>
{{--                            <th scope="col">Статус</th>--}}
                            <th scope="col">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#InsertCityModal">Добавить город</button>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($cities as $city)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{ $city->city_name }}</span>
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
                                <td>
    {{--                                <label class="custom-toggle">--}}
    {{--                                    <input type="checkbox" checked>--}}
    {{--                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>--}}
    {{--                                </label>--}}
                                    <!-- <div class="d-flex align-items-center">
                                      <div class="btn btn-sm btn-primary">Активный</div>
                                      <button class="btn ni ni-fat-remove btn-sm btn-primary2" type="button"> Остановить </button>
                                    </div> -->
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="InsertCityModal" tabindex="-1" role="dialog" aria-labelledby="InsertCityModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="InsertCityModalLabel">Заполните</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{route('storeCityAndChat')}}">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="CountriesFormControlSelect">Выберите страну</label>
                                        <select class="form-control" id="CountriesFormControlSelect" name="country_id">
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="city_name" id="city_name" placeholder="Название Города">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="chat_name" id="chat_name" placeholder="Название Чата">
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
                    <nav aria-label="..." class="table-responsive" style="flex-wrap: wrap;">
                       {{ $cities->links("pagination::bootstrap-4") }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
