@extends("layout.main")
@section("content")
<div class="container">
    <h1>Курсы</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Наименование курса</th>
            <th scope="col" data-edit-col="number" data-edit-type="input">Номер курса</th>
            <th scope="col">Университет</th>
            <th scope="col" data-edit-col="chair" data-edit-type="select" data-edit-target="chairSelect">Кафедра</th>
            <th scope="col">Предметы</th>
            <th scope="col">Изменить</th>
        </tr>
        <tr data-headers >
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="name"></th>
            <th scope="col"><input type="text" name="number"></th>
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
                <select name="chair_id">
                    <option value="">-</option>
                    @foreach($chairs as $chair)
                        <option value="{{$chair["id"]}}">
                            {{$chair["name"]}}
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
                <button data-btn="search" class="btn btn-primary">Найти</button>
            </th>
        </tr>
        </thead>
        <tbody data-table-body>
        @foreach($courses as $course)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $course["id"]}}"></td>
                <td>{{ $course["id"] }}</td>
                <td>{{ $course["name"] }}</td>
                <td>{{ $course["number"] }}</td>
                <td>
                    @if (isset($course["university"]))
                        <ul>
                            <li data-id="{{$course["university"]["id"]}}">{{$course["university"]["name"]}}</li>
                        </ul>
                    @endif
                </td>
                <td>
                    @if (isset($course["chair"]))
                        <ul @if(isset($course["universityChairs"]))
                                data-filter="{{json_encode($course["universityChairs"])}}"
                            @endif >
                                <li data-id="{{$course["chair"]["id"]}}">{{$course["chair"]["name"]}}</li>
                        </ul>
                    @endif
                </td>
                <td>
                    @if ($course["programs"])
                        <ul>
                            @foreach($course["programs"] as $program)
                                <li data-id="{{$program["id"]}}">{{$program["name"]}}</li>
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
    <template id="chairSelect">
        <select class="form-select">
            @foreach($chairs as $chair)
                <option value="{{$chair["id"]}}">{{$chair["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="name" class="form-control" type="text"></td>
            <td><input name="number" class="form-control" type="text"></td>
            <td>
                <select name="university" data-filter-target="chair">
                    @foreach($universities as $university)
                        <option data-filter-id="{{json_encode($university["chairs"])}}" value="{{$university["id"]}}">{{$university["name"]}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="chair">
                    @foreach($chairs as $chair)
                        <option value="{{$chair["id"]}}">{{$chair["name"]}}</option>
                    @endforeach
                </select>
            </td>
            <td></td>
            <td>
                <input type="button" data-btn="add" value="✔">
                <input type="button" data-btn="decline" value="✖">
            </td>
        </tr>
    </template>
</div>
@stop
