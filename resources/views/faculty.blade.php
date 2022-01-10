@extends("layout.main")
@section("content")
<div class="container">
    <h1>Факультеты</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
    <table class="table">
        <thead>
        <tr data-headers >
            <th scope="col"><input data-select-all type="checkbox"></th>
            <th scope="col">#</th>
            <th scope="col" data-edit-col="name" data-edit-type="input">Факультет</th>
            <th scope="col">Кафедра</th>
            <th scope="col">Изменить</th>
        </tr>
        <tr data-search-filter class="findElem" style="display: none">
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="name"></th>
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
                <button data-btn="search" class="btn btn-primary">Найти</button>
            </th>
        </tr>
        </thead>
        <tbody data-table-body>
        @foreach($faculties as $faculty)
            <tr>
                <td><input type="checkbox" data-checkbox value="{{ $faculty["id"]}}"></td>
                <td>{{ $faculty["id"] }}</td>
                <td>{{ $faculty["name"] }}</td>
                <td>
                    @if ($faculty["chairs"])
                        <ul>
                            @foreach($faculty["chairs"] as $chair)
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
    @include('components.pagination')
    <template id="chairSelect">
        <select multiple>
            @foreach($chairs as $chair)
                <option value="{{$chair["id"]}}">{{$chair["name"]}}</option>
            @endforeach
        </select>
    </template>
    <template id="addElement">
        <tr>
            <td></td>
            <td></td>
            <td><input name="name" type="text"></td>
            <td></td>
            <td>
                <input type="button" data-btn="add" value="✔">
                <input type="button" data-btn="decline" value="✖">
            </td>
        </tr>
    </template>
</div>
@stop
