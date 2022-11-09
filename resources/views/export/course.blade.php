<table>
    <thead>
    <tr>
        <th>
            #
        </th>
        <th style=" width: 50px">
            Название
        </th>
        <th style=" width: 50px">
            Учитель
        </th>
        <th>
            Процент заполнения
        </th>
        <th>
            Модули и темы
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($courses as $course)
        <tr>
            <td>
                {{ $loop->iteration }}
            </td>
            <td style=" width: 50px">
                {{ $course->title }}
            </td>
            <td style=" width: 50px">
                {{ $course->user->name }}
            </td>
            <td>
                {{ $course->percent() }}%
            </td>
            <td>
                <table>
                    @foreach ($course->chapters as $chapter)
                        <tr>
                            <td style="font-weight: bold; width: 50px">Название модуля</td>
                            <td style="font-weight: bold;">Процент заполнения модуля</td>
                        </tr>
                        <tr>
                            <td style=" width: 50px">
                                {{ $chapter->title }}
                            </td>
                            <td>
                                {{ $chapter->percent() }}%
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 50px">Название темы</td>
                            <td style="font-weight: bold;">Процент заполнения темы</td>
                        </tr>
                        @foreach ($chapter->themes as $theme)
                            <tr>
                                <td style=" width: 50px">
                                    {{ $theme->title }}
                                </td>
                                <td>
                                    {{ $theme->percent() }}%
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
