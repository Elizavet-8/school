@component('mail::message')
# Вам было отказано в получении доступа!

Причина отказа:<br>
{{ $data['reason'] }}

С уважением,<br>
Андрей Реутов
@endcomponent
