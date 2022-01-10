@extends("layout.main")
@section("content")
<div class="container">
    <h1>Предметы</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Наименование</th>
            <th scope="col" data-edit-col="lecturers" data-edit-type="select" data-edit-target="lecturersSelect">Преподаватели</th>
            <th scope="col">Изменить</th>
        </tr>
        <tr data-search-filter class="findElem" style="display: none">
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="name"></th>
            <th scope="col">
                <select name="lecturer_id">
                    <option value="">-</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{$lecturer["id"]}}">
                            {{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}
                        </option>
                    @endforeach
                </select>
            </th>
            <th scope="col">
                <button data-btn="search" class="btn btn-primary">Найти</button>
            </th>
        </tr>
        </thead>
        <tbody data-table-body>
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
@stop
