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
    <title>Chairs</title>
</head>
<body>

<div class="container">
    <h1>Chairs</h1>
    <input type="button" data-btn-remove value="✖">
    <input type="button" data-btn-add value="✚">
    <input type="button" data-btn-add value="❍">
    <table class="table">
        <tr data-headers >
            <th scope="col"><input type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Наименование</th>
            <th scope="col" data-edit-col="university" data-edit-type="select" data-edit-target="universitySelect">Университеты</th>
            <th scope="col">Изменить</th>
        </tr>
        @foreach($chairs as $chair)
            <tr>
                <td><input type="checkbox" value="{{ $chair["id"]}}"></td>
                <td>{{ $chair["id"] }}</td>
                <td>{{ $chair["name"] }}</td>
                <td>
                    @if ($chair["universities"])
                        <ul>
                            @foreach($chair["universities"] as $university)
                                <li data-id="{{$university["id"]}}">{{$university["name"]}}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td><input type="button" data-btn="edit" value="✎"></td>
            </tr>
        @endforeach
    </table>
    <template id="universitySelect">
        <select multiple>
            @foreach($universities as $university)
                <option value="{{$university["id"]}}">
                    {{$university["name"]}}
                </option>
            @endforeach
        </select>
    </template>
</div>

</body>
</html>

