<table>
    <thead>
    <tr>
        <th>
            #
        </th>
        <th>
            Название
        </th>
        <th>
            Учитель
        </th>
        <th>
            Процент заполнения
        </th>
        <th>
            Модули
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($courses as $course)
        <tr>
            <td>
                {{ $loop->iteration }}
            </td>
            <td>
                {{ $course->title }}
            </td>
            <td>
                {{ $course->user->name }}
            </td>
            <td>
                {{ $course->percent() }}%
            </td>
            <td>
                <table>
                    <tr>
                        <td style="font-weight: bold;">Название модуля</td>
                        <td style="font-weight: bold;">Процент заполнения модуля</td>
                    </tr>
                    @foreach ($course->chapters as $chapter)
                        <tr>
                            <td>
                                {{ $chapter->title }}
                            </td>
                            <td>
                                {{ $chapter->percent() }}%
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
