@extends("layout.main")
@section("content")
<div class="container">
    <h1>Группы</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <br>
    <input class="findElem" type="text" style="display: none" placeholder="Введите искомый текст">
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Группа</th>
            <th scope="col" data-edit-col="courses" data-edit-type="select" data-edit-target="courseSelect">Курс</th>
            <th scope="col">Изменить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $group["id"]}}"></td>
                <td>{{ $group["id"] }}</td>
                <td>{{ $group["name"] }}</td>
                <td>
                    @if ($group["courses"])
                        <ul>
                            @foreach($group["courses"] as $course)
                                <li data-id="{{$course["id"]}}">{{$course["name"]}}</li>
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
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="name" type="text"></td>
            <td>
                <select name="courses">
                    @foreach($courses as $course)
                        <option value="{{$course["id"]}}">{{$course["name"]}}</option>
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
@stop
