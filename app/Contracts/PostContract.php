<?php


namespace App\Contracts;


class PostContract
{
    const POST_SELECT_DATA = [
        'requests.id',
        'requests.category_id',
        'requests.city_id',
        'requests.user_id',
        'users.name',
        'users.surname',
        'users.photo_path as user_image',
        'requests.photo_path as post_image',
        'requests.description',
        'requests.seen',
        'requests.likes',
        'requests.updated_at as date',
    ];

    const POST_SELECT_COMMENTS = [
        'comments.comment',
        'comments.user_id',
        'users.name',
        'users.surname',
        'users.photo_path as user_image',
        'comments.created_at as date',
    ];

    const POST_SHOW_SELECT_DATA = [
        'requests.id',
        'requests.category_id',
        'requests.city_id',
        'requests.user_id',
        'requests.photo_path as post_image',
        'requests.description',
        'requests.seen',
        'requests.likes',
        'requests.updated_at as date',
    ];
}
