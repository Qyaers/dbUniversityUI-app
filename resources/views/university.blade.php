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
    <title>University</title>
</head>
<body>

<div class="container">
    <h1>University</h1>
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
            <th scope="col" data-edit-col="address" data-edit-type="input">Адресс</th>
            <th scope="col" data-edit-col="chairs" data-edit-type="select" data-edit-target="chairsSelect">Кафедра</th>
            <th scope="col">Изменить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Universities as $university)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $university["id"]}}"></td>
                <td>{{ $university["id"] }}</td>
                <td>{{ $university["name"] }}</td>
                <td>{{ $university["address"] }}</td>
                <td>
                    @if ($university["chairs"])
                        <ul>
                            @foreach($university["chairs"] as $chair)
                                <li data-id="{{$chair["id"]}}">{{$chair["name"]}}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td><input type="button" data-btn="edit" value="✎"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @if($cur_page-1 > 0)
                <li class="page-item"><a class="page-link" href="/dbEditor/University?page={{ $cur_page-1 }}">Previous</a></li>
            @else
                <li class="page-item active"><span class="page-link">Previous</span></li>
            @endif

            @for($page=1; $page <= $count_page; $page++)
                @if($page == $cur_page)
                    <li class="page-item active"><span class="page-link">{{$page}}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="/dbEditor/University?page={{ $page }}">{{$page}}</a></li>
                @endif
            @endfor

            @if($cur_page+1 <= $count_page)
                    <li class="page-item"><a class="page-link" href="/dbEditor/University?page={{ $cur_page+1 }}">Next</a></li>
            @else
                    <li class="page-item active"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
    <template id="chairsSelect">
        <select multiple>
            @foreach($chairs as $chair)
                <option value="{{$chair["id"]}}">
                    {{$chair["name"]}}
                </option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="name" type="text"></td>
            <td><input name="address" type="text"></td>
            <td>
                <select multiple name="chairs">
                    @foreach($chairs as $chair)
                        <option value="{{$chair["id"]}}">
                            {{$chair["name"]}}
                        </option>
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
