@extends('ParentHTML.ParentHTML')

@section('page-title') Категории @endsection

@section('page-body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                @include('layouts.AlertManager')
                <div class="card-header border-0">
                    <h3 class="mb-0">Категорий</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Название</th>
                            <th scope="col" class="sort" data-sort="budget">Фото</th>
                            <th scope="col" class="sort" data-sort="budget">Статус</th>
                            <th scope="col">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#InsertCategoryModal">Добавить категорию</button>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($categories as $category)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$category->category_name}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        <button class="fas fa-image btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ImageModal_{{$category->id}}"></button>
                                        <!-- Modal Box for image -->
                                        <div class="modal fade" id="ImageModal_{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="ImageModalCenterTitle_{{$category->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ImageModalCenterTitle_{{$category->id}}"> Фотография категории {{$category->name}}</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img class="img-thumbnail" src="/{{$category->image_path}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{route('updateStatusCategory', $category->id)}}">
                                            @csrf
                                            <label class="custom-toggle">
                                                <button style="outline: none; border: none;" type="submit">
                                                    <input id="status-checker" type="checkbox" @if($category->status === 1) {!! 'checked' !!} @endif>
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                </button>
                                            </label>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="modal fade" id="InsertCategoryModal" tabindex="-1" role="dialog" aria-labelledby="InsertCategoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="InsertCategoryModalLabel">Заполните</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{route('storeCategory')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="category_name" placeholder="Название категорий">
                                        </div>
                                        <div class="custom-file mt-md-3">
                                            <input type="file" class="custom-file-input" name="img" id="customFile">
{{--                                            <label class="custom-file-label" for="customFile">Выберите фото</label>--}}
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
                        {{ $categories->links("pagination::bootstrap-4") }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
