@component('mail::message')
# Заявка на регистрацию 

Анкета пользователя:<br>
Имя и фамилия родителя: {{ $data['fio'] }}<br>
Номер телефона: {{ $data['phone'] }}<br>
Электронная почта: {{ $data['email'] }}<br>
Место регистрации: {{ $data['place'] }}<br>
Класс: {{ $data['grade'] }}<br>
Пакет обучения: {{ $data['program'] }}<br>
{{-- Дополнительная программа обучения: {{ $data['additional'] }}<br>
Пакет консультаций: {{ $data['consult'] }}<br> --}}

@endcomponent
