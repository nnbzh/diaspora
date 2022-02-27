@extends('ParentHTML.ParentHTML')

@section('page-title') Чаты @endsection

@section('page-body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Чаты</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Название чата</th>
                            <th scope="col" class="sort" data-sort="budget">Город чата</th>
                            <!-- <th scope="col">СТрана чата</th> -->
                            <th scope="col" class="sort" data-sort="status">Кол-во пользователей</th>
{{--                            <th scope="col">Статус</th>--}}
                            <th scope="col">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#InsertCityModal">Добавить чат</button>
                            </th>

                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($chats as $ch)
                        <!-- {{ var_dump($ch) }} -->
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{ $ch->chat_name }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="budget">
                                    {{ $ch->chat_city->city_name }}
                                </td>
                                <!-- <td>
                          <span class="badge badge-dot mr-4">
                            <span class="status">{{ $ch->country_name }}</span>
                          </span>
                                </td> -->
                                <td class="budget">
                                    {{ $ch->chat_users_count }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#EditCityModal_{{$ch->id}}">Изменить</button>
                                    <div class="modal fade" id="EditCityModal_{{$ch->id}}" tabindex="-1" role="dialog" aria-labelledby="EditCityModal_{{$ch->id}}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="EditCountryModal_{{$ch->id}}"> Редактировать название города {{$ch->chat_name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-sm-12">
                                                        <form method="POST" action="/admin/chat/edit/{{ $ch->id }}">
                                                            @csrf
                                                            <div class="form-group">
                                                                <input class="form-control" name="chat_name" value="{{$ch->chat_name}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <select class="form-control select-country-edit">
                                                                    <option selected disabled>Выберите страну</option>
                                                                    @foreach($countries as $country)
                                                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group select-city-edit-block">
                                                                <select class="form-control select-city-edit" name="city_id">
                                                                    <option selected disabled>Выберите город</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" action="/admin/chat/desctroy/{{ $ch->id }}">
                                        @csrf
                                        <button class="btn btn-sm btn-danger" type="submit">Удалить</button>
                                    </form>

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
                            <form method="POST" action="/admin/chat/store">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="chat_name" id="chat_name" placeholder="Название Чата">
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" id="select-country-add">
                                            <option selected disabled>Выберите страну</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="CountriesFormControlSelect">Выберите город</label>
                                        <select class="form-control" id="CountriesFormControlSelect" name="city_id">
                                            <option selected disabled>Выберите город</option>
                                        </select>
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
                       {{ $chats->links("pagination::bootstrap-4") }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
$('#select-country-add').change(function() {
    let country_id = $(this).val();
    $.ajax({
        url: '/api/city/list',
        type: 'GET',
        dataType: 'json',
        data: {country_id: country_id},
        cache: false,
        success: data => {
             $('#CountriesFormControlSelect').val('');
             $('#CountriesFormControlSelect').html('');
             $('#CountriesFormControlSelect').append('<option selected disabled>Выберите город</option>')
             for (var v in data) {
                 $('#CountriesFormControlSelect').append('<option value="'+ data[v].id +'">'+ data[v].city_name +'</option>');
             }
        },
    });
});
$('.select-country-edit').change(function() {
    let country_id = $(this).val();
    let edit_selector = $('.select-city-edit');

        console.log(edit_selector);
    $.ajax({
        url: '/api/city/list',
        type: 'GET',
        dataType: 'json',
        data: {country_id: country_id},
        cache: false,
        success: data => {
            edit_selector.val('');
            edit_selector.html('');
            edit_selector.append('<option selected disabled>Выберите город</option>')
            for (var v in data) {
                edit_selector.append('<option value="'+ data[v].id +'">'+ data[v].city_name +'</option>');
            }
        },
    });
});
</script>
@endsection
