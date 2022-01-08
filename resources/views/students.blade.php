@extends("layout.main")
@section("content")
<div class="container">
    <h1>Студенты</h1>
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
            <th scope="col" data-edit-col="firstName" data-edit-type="input">Фамилия</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Имя</th>
            <th scope="col" data-edit-col="secondName" data-edit-type="input">Отчество</th>
            <th scope="col" data-edit-col="role" data-edit-type="select" data-edit-target="roleSelect">Роль</th>
            <th scope="col" data-edit-col="group" data-edit-type="select" data-edit-target="groupSelect">Группа</th>
            <th scope="col">Изменить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $student["id"]}}"></td>
                <td>{{ $student["id"] }}</td>
                <td>{{$student["firstName"]}}</td>
                <td>{{$student["name"]}}</td>
                <td>{{$student["secondName"]}}</td>
                <td>
                    <ul>
                        <li>
                            @if($student["role"])
                                Староста
                            @else
                                Студент
                            @endif
                        </li>
                    </ul>
                </td>
                <td>
                    @if ($student["group"])
                        <ul>
                            @foreach($student["group"] as $group)
                                <li data-id="{{$group["id"]}}">
                                    {{$group["name"]}}
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
    <template id="groupSelect">
        <select>
            @foreach($groups as $group)
                <option value="{{$group["id"]}}">{{$group["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="roleSelect">
        <select name="role">
            <option value="1">Староста</option>
            <option value="0">Студент</option>
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="firstName" type="text"></td>
            <td><input name="name" type="text"></td>
            <td><input name="secondName" type="text"></td>
            <td>
                <select name="role">
                    <option value="1">Староста</option>
                    <option value="0">Студент</option>
                </select>
            </td>
            <td>
                <select name="group">
                    @foreach($groups as $group)
                        <option value="{{$group["id"]}}">
                            {{$group["name"]}}
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
@stop
