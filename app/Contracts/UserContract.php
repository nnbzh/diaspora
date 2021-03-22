<?php


namespace App\Contracts;


class UserContract
{
    const SHOW_SELECT_DATA = [
        'id',
        'surname',
        'username',
        'name',
        'gender',
        'email',
        'phone_number',
        'birthday',
        'marital_status',
        'whatsapp',
        'telegram',
        'IMO',
        'viber',
        'instagram',
        'facebook',
        'twitter',
        'city_id',
        'photo_path as user_image',
        'native_country_id',
    ];
}
