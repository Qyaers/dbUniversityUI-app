@extends("layout.main")
@section("content")
<div class="container">
    <h1>Программы</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
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
        <tr data-search-filter class="findElem" style="display: none">
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="hours"></th>
            <th scope="col">
                <select name="course_id">
                    <option value="">-</option>
                    @foreach($courses as $course)
                        <option value="{{$course["id"]}}">
                            {{$course["name"]}}
                        </option>
                    @endforeach
                </select>
            </th>
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
                <select name="lecturer_id">
                    <option value="">-</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{$lecturer["id"]}}">
                            {{$lecturer["firstName"]}} {{$lecturer["name"]}} {{$lecturer["secondName"]}}
                        </option>
                    @endforeach
                </select>
            </th>
            <th>
                <button data-btn="search" class="btn btn-primary">Найти</button>
            </th>
        </tr>
        </thead>
        <tbody data-table-body>
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
@stop
