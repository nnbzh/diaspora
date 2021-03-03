@extends('ParentHTML.ParentHTML')

@section('page-title') Запросы @endsection

@section('page-body')

    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Запросы на Объявлений</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name" style="text-align: left;">ФИО</th>
                            <th scope="col" class="sort" data-sort="budget">Название</th>
                            <th scope="col" class="sort" data-sort="status">Описание</th>
                            <th scope="col">Город</th>
                            <th scope="col" class="sort" data-sort="completion">Фото</th>
                            <th scope="col">Статус</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">Уринбаев Момын Усенович</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                Продам дом 3 этажный в Тайланде
                            </td>
                            <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">Кому интересно дом в острове Пханган</span>
                      </span>
                            </td>
                            <td class="budget">
                                Пханган
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="ni ni-check-bold btn btn-sm btn-primary" type="button"></button>
                                    <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Профиль</a>
                                        <a class="dropdown-item" href="#">Объявлений</a>
                                        <a class="dropdown-item" href="#">Заблокировать</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">Уринбаев Момын Усенович</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                Продам дом 3 этажный в Тайланде
                            </td>
                            <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">Кому интересно дом в острове Пханган</span>
                      </span>
                            </td>
                            <td class="budget">
                                Пханган
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="ni ni-check-bold btn btn-sm btn-primary" type="button"></button>
                                    <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Профиль</a>
                                        <a class="dropdown-item" href="#">Объявлений</a>
                                        <a class="dropdown-item" href="#">Заблокировать</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">Уринбаев Момын Усенович</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                Продам дом 3 этажный в Тайланде
                            </td>
                            <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">Кому интересно дом в острове Пханган</span>
                      </span>
                            </td>
                            <td class="budget">
                                Пханган
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="ni ni-check-bold btn btn-sm btn-primary" type="button"></button>
                                    <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Профиль</a>
                                        <a class="dropdown-item" href="#">Объявлений</a>
                                        <a class="dropdown-item" href="#">Заблокировать</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">Уринбаев Момын Усенович</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                Продам дом 3 этажный в Тайланде
                            </td>
                            <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">Кому интересно дом в острове Пханган</span>
                      </span>
                            </td>
                            <td class="budget">
                                Пханган
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="ni ni-check-bold btn btn-sm btn-primary" type="button"></button>
                                    <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Профиль</a>
                                        <a class="dropdown-item" href="#">Объявлений</a>
                                        <a class="dropdown-item" href="#">Заблокировать</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">Уринбаев Момын Усенович</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                Продам дом 3 этажный в Тайланде
                            </td>
                            <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">Кому интересно дом в острове Пханган</span>
                      </span>
                            </td>
                            <td class="budget">
                                Пханган
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="ni ni-check-bold btn btn-sm btn-primary" type="button"></button>
                                    <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Профиль</a>
                                        <a class="dropdown-item" href="#">Объявлений</a>
                                        <a class="dropdown-item" href="#">Заблокировать</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">Уринбаев Момын Усенович</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                Продам дом 3 этажный в Тайланде
                            </td>
                            <td>
                      <span class="badge badge-dot mr-4">
                        <span class="status">Кому интересно дом в острове Пханган</span>
                      </span>
                            </td>
                            <td class="budget">
                                Пханган
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="fas fa-image btn btn-sm btn-primary" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="ni ni-check-bold btn btn-sm btn-primary" type="button"></button>
                                    <button class="ni ni-fat-remove btn btn-sm btn-primary2" type="button"></button>
                                    <div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Профиль</a>
                                        <a class="dropdown-item" href="#">Объявлений</a>
                                        <a class="dropdown-item" href="#">Заблокировать</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
