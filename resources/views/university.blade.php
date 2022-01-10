@extends("layout.main")
@section("content")
<div class="container">
    <h1>Университеты</h1>
    <input type="button" data-btn="remove" value="✖">
    <input type="button" data-btn="newElem" value="✚">
    <input type="button" data-btn="filterElem"  value="❍">
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
        <tr data-search-filter class="findElem" style="display: none">
            <th scope="col"></th>
            <th scope="col"><input type="text" name="id"></th>
            <th scope="col"><input type="text" name="name"></th>
            <th scope="col"><input type="text" name="address"></th>
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
    @include('components.pagination')
    <template id="chairsSelect">
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
            <td><input name="address" type="text"></td>
            <td>
                <select multiple name="chairs">
                    @foreach($chairs as $chair)
                        <option value="{{$chair["id"]}}">{{$chair["name"]}}</option>
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
