<nav class="container mt-4">
    <ul class="nav nav-pills nav-fill">
        @foreach(Config::get("menu") as $link)
                @if (Request::is($link["link"]))
                <li class="nav-link active">
                    {{$link["title"]}}
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="/{{$link["link"]}}">{{$link["title"]}}</a>
                </li>
            @endif

        @endforeach
    </ul>
</nav>
