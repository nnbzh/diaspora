<?php


namespace App\Contracts;


class UserContract
{
    const SHOW_SELECT_DATA = [
        'users.id',
        'users.surname',
        'users.username',
        'users.name',
        'users.gender',
        'users.email',
        'users.phone_number',
        'users.photo_path as user_image',
        'users.birthday',
        'users.marital_status',
        'users.whatsapp',
        'users.telegram',
        'users.IMO',
        'users.viber',
        'users.instagram',
        'users.facebook',
        'users.twitter',
        'users.city_id',
        'cities.city_name',
        'countries.id as country_id',
        'countries.country_name',
        'users.native_country_id as native_city_id',
        'native_cities.city_name as native_city_name',
        'native_countries.id as native_country_id',
        'native_countries.country_name as native_country_name',
    ];

    const COUNTRY_USERS_SELECT = [
        'id',
        'username',
        'surname',
        'name',
        'photo_path as user_image',
    ];

    const MARITIAL_STATUSES = [
        1 => 'Женат',
        2 => 'Не женат',
        3 => 'Путешествую',
        4 => 'Ищу общения',
        5 => 'Учусь',
        6 => 'Работаю',
        7 => 'Переезжаю',
        8 => 'Постоянно проживаю',
    ];
}
