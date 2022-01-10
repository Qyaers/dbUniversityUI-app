@extends("layout.main")
@section("content")
<div class="container">
    <h1>Кафедры</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Наименование</th>
            <th scope="col" data-edit-col="faculties" data-edit-type="select" data-edit-target="facultySelect">Факультет</th>
            <th scope="col" data-edit-col="universities" data-edit-type="select" data-edit-target="universitySelect">Университет</th>
            <th scope="col">Изменить</th>
        </tr>
        <tr data-search-filter class="findElem" style="display: none">
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="name"></th>
            <th scope="col">
                <select name="faculty_id">
                    <option value="">-</option>
                    @foreach($faculties as $faculty)
                        <option value="{{$faculty["id"]}}">
                            {{$faculty["name"]}}
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
        @foreach($chairs as $chair)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $chair["id"]}}"></td>
                <td>{{ $chair["id"] }}</td>
                <td>{{ $chair["name"] }}</td>
                <td>
                    @if ($chair["faculties"])
                        <ul>
                            @foreach($chair["faculties"] as $faculty)
                                <li data-id="{{$faculty["id"]}}">{{$faculty["name"]}}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
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
        </tbody>
    </table>
    @include('components.pagination')
    <template id="facultySelect">
        <select multiple>
            @foreach($faculties as $faculty)
                <option value="{{$faculty["id"]}}">{{$faculty["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="universitySelect">
        <select multiple>
            @foreach($universities as $university)
                <option value="{{$university["id"]}}">{{$university["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="name" type="text"></td>
            <td>
                <select name="faculties">
                    @foreach($faculties as $faculty)
                        <option value="{{$faculty["id"]}}">{{$faculty["name"]}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select multiple name="universities">
                    @foreach($universities as $university)
                        <option value="{{$university["id"]}}">{{$university["name"]}}</option>
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
