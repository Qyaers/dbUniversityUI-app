<!doctype html>
<html lang="en">

<head>
{{--TODO шаблон program--}}
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
    <title>Program</title>
</head>
<body>

<div class="container">
    <h1>Program</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <br>
    <input class="findElem" type="text" style="display: none" placeholder="Введите искомый текст">
    {{--    <pre>--}}
    {{--        {{ print_r($count_page, true) }}--}}
    {{--        {{ print_r($cur_page, true)  }}--}}
    {{--    </pre>--}}
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="hours" data-edit-type="input">Количество часов</th>
            <th scope="col" data-edit-col="courses" data-edit-type="select" data-edit-target="courseSelect">Курс</th>
            <th scope="col" data-edit-col="subjects" data-edit-type="select" data-edit-target="subjectSelect">Предмет</th>
            <th scope="col" data-edit-col="lecturers" data-edit-type="select" data-edit-target="lecturerSelect">Преподаватель</th>
            <th scope="col">Изменить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($programs as $program)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $program["id"]}}"></td>
                <td>{{ $program["id"] }}</td>
                <td>{{ $program["hours"] }}</td>
                <td>
                    @if ($program["courses"])
                        <ul>
                            @foreach($program["courses"] as $course)
                                <li data-id="{{$course["id"]}}">{{$course["name"]}}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    @if ($program["subjects"])
                        <ul>
                            @foreach($program["subjects"] as $subject)
                                <li data-id="{{$subject["id"]}}">{{$subject["name"]}}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    @if ($program["lecturers"])
                        <ul>
                            @foreach($program["lecturers"] as $lecturer)
                                <li data-id="{{$lecturer["id"]}}">{{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td><input type="button" data-btn="edit" value="✎"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
        @include('components.pagination')
    <template id="courseSelect">
        <select>
            @foreach($courses as $course)
                <option value="{{$course["id"]}}">{{$course["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="subjectSelect">
        <select>
            @foreach($subjects as $subject)
                <option value="{{$subject["id"]}}">{{$subject["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="lecturerSelect">
        <select>
            @foreach($lecturers as $lecturer)
                <option value="{{$lecturer["id"]}}">{{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="hours" type="text"></td>
            <td>
                <select name="courses">
                    @foreach($courses as $course)
                        <option value="{{$course["id"]}}">{{$course["name"]}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="subjects">
                    @foreach($subjects as $subject)
                        <option value="{{$subject["id"]}}">{{$subject["name"]}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="lecturers">
                    @foreach($lecturers as $lecturer)
                        <option value="{{$lecturer["id"]}}">{{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="button" data-btn="add" value="✔">
                <input type="button" data-btn="decline" value="✖">
            </td>
        </tr>
    </template>
</div>
</body>
</html>
