<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
    <title>Subject</title>
</head>
<body>

<div class="container">
    <h1>Subject</h1>
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
            <th scope="col" data-edit-col="name" data-edit-type="input">Наименование</th>
            <th scope="col" data-edit-col="lecturers" data-edit-type="select" data-edit-target="lecturersSelect">Преподаватели</th>
            <th scope="col">Изменить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects as $subject)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $subject["id"]}}"></td>
                <td>{{ $subject["id"] }}</td>
                <td>{{ $subject["name"] }}</td>

                <td>
                    @if ($subject["lecturers"])
                        <ul>
                            @foreach($subject["lecturers"] as $lecturer)
                                <li data-id="{{$lecturer["id"]}}">
                                    {{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}
                                </li>
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
    <template id="lecturersSelect">
        <select multiple>
            @foreach($lecturers as $lecturer)
                <option value="{{$lecturer["id"]}}">{{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="name" type="text"></td>
            <td>
                <select multiple name="lecturers">
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
