@component('mail::message')
# Заявка на регистрацию

Данные пользователя:<br>
ФИО: {{ $data['name'] }}<br>
Класс: {{ $data['grade'] }}<br>
Почта: {{ $data['email'] }}<br>
Телефон представителя: {{ $data['phone'] }}<br>

@endcomponent
