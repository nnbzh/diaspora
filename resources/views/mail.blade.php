@component('mail::message')
Новая запись на консультацию!


Логин клиента:
{{$input["login"]}} <br>
Сообщение:
{{$input["text"]}} <br>

Сообщение отправлено автоматически
@endcomponent