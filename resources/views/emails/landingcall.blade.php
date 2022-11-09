@component('mail::message')
# Заявка на обратный звонок 

Имя: {{ $data['name'] }}<br>
Номер телефона: {{ $data['phone'] }}<br>

@endcomponent
