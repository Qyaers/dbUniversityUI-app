<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/js/app.js"></script>
    <title>University</title>
</head>
<body>

<h1>University</h1>
<table class="table">
    <tr data-headers >
        <th scope="col"><input type="checkbox"></th>
        <th scope="col">#</th>
        <th scope="col" data-edit-col="name">Name</th>
        <th scope="col" data-edit-col="address">Address</th>
        <th scope="col">Edit</th>
    </tr>
    @foreach($Universities as $university)
        <tr>
            <td><input type="checkbox" value="{{ $university["id"]}}"></td>
            <td>{{ $university["id"] }}</td>
            <td>{{ $university["name"] }}</td>
            <td>{{ $university["address"] }}</td>
            <td><input type="button" data-btn="edit" value="✎"></td>
        </tr>
    @endforeach
</table>
</body>
</html>
