@component('mail::message')
# Ваша заявка на получение доступа одобрена!

Ваши логин и пароль для входа в систему:<br>
Login: {{ $data['login'] }}<br>
Password: {{ $data['password'] }}

С уважением,<br>
Андрей Реутов
@endcomponent
