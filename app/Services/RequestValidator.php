<?php


namespace App\Services;


use Illuminate\Support\Facades\Validator;

class RequestValidator
{

    public function registerValidate($req) {
        $messages = [
            'username.required' => 'Имя пользователя не указана',
            'username.unique' => 'Пользователь под таким именем пользователя уже зарегистрирован',
            'password.required' => 'Пароль не указан',
            'password.min' => 'Пароль не должен быть меньше 6 символов',
            'password.max' => 'Пароль не должен быть больше 16 символов',
            'name.required' => 'Имя и фамилия не указаны',
            'surname.required' => 'Имя и фамилия не указаны',
        ];
        $data = [
            'password' => 'required|min:6|max:16',
            'name' => 'required',
            'surname' => 'required',
        ];
        if (isset($req['email'])) {
            $messages['email.required'] = 'E-mail не указан';
            $messages['email.unique'] = 'Пользователь под таким e-mail уже зарегистрирован';
            $data['email'] = 'required|unique:users';
        } else {
            $messages['phone_number.required'] = 'Номер телефона не указан';
            $messages['phone_number.unique'] = 'Пользователь под таким номером уже зарегистрирован';
            $data['phone_number'] = 'required|unique:users';
        }
        return Validator::make($req, $data, $messages);
    }

}
