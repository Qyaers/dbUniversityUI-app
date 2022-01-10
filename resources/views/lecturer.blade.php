@extends("layout.main")
@section("content")
<div class="container">
    <h1>Преподаватели</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="firstName" data-edit-type="input">Фамилия</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Имя</th>
            <th scope="col" data-edit-col="secondName" data-edit-type="input">Отчество</th>
            <th scope="col" data-edit-col="position" data-edit-type="input">Должность</th>
            <th scope="col" data-edit-col="subjects" data-edit-type="select" data-edit-target="subjectSelect">Предметы</th>
            <th scope="col" data-edit-col="university" data-edit-type="select" data-edit-target="universitySelect">Университет</th>
            <th scope="col">Изменить</th>
        </tr>
        <tr data-search-filter class="findElem" style="display: none">
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="firstName"></th>
            <th scope="col"><input type="text" name="name"></th>
            <th scope="col"><input type="text" name="secondName"></th>
            <th scope="col"><input type="text" name="position"></th>
            <th scope="col">
                <select name="subject_id">
                    <option value="">-</option>
                    @foreach($subjects as $subject)
                        <option value="{{$subject["id"]}}">
                            {{$subject["name"]}}
                        </option>
                    @endforeach
                </select>
            </th>
            <th scope="col">
                <select name="university_id">
                    <option value="">-</option>
                    @foreach($universities as $university)
                        <option value="{{$university["id"]}}">
                            {{$university["name"]}}
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
        @foreach($lecturers as $lecturer)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $lecturer["id"]}}"></td>
                <td>{{$lecturer["id"] }}</td>
                <td>{{$lecturer["firstName"]}}</td>
                <td>{{$lecturer["name"]}}</td>
                <td>{{$lecturer["secondName"]}}</td>
                <td>{{$lecturer["position"]}}</td>
                <td>
                    @if ($lecturer["subjects"])
                        <ul>
                            @foreach($lecturer["subjects"] as $subject)
                                <li data-id="{{$subject["id"]}}">
                                    {{$subject["name"]}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    @if ($lecturer["university"])
                        <ul>
                            @foreach($lecturer["university"] as $university)
                                <li data-id="{{$university["id"]}}">
                                    {{$university["name"]}}
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
    <template id="subjectSelect">
        <select multiple>
            @foreach($subjects as $subject)
                <option value="{{$subject["id"]}}">{{$subject["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="universitySelect">
        <select>
            @foreach($universities as $university)
                <option value="{{$university["id"]}}">{{$university["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="positionSelect">
        <select name="position">
            @foreach($lecturers as $lecturer)
                <option value="{{$lecturer["id"]}}">{{$lecturer["position"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="firstName" type="text"></td>
            <td><input name="name" type="text"></td>
            <td><input name="secondName" type="text"></td>
            <td><input name="position" type="text"></td>
            <td>
                <select multiple name="subjects">
                    @foreach($subjects as $subject)
                        <option value="{{$subject["id"]}}">
                            {{$subject["name"]}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="university">
                    @foreach($universities as $university)
                        <option value="{{$university["id"]}}">
                            {{$university["name"]}}
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

