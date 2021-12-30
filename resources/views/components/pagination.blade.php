<nav aria-label="Page navigation example">
    <ul class="pagination">
        @if($cur_page-1 > 0)
            <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $cur_page-1 }}">Previous</a></li>
        @else
            <li class="page-item active"><span class="page-link">Previous</span></li>
        @endif

        @for($page=1; $page <= $count_page; $page++)
            @if($page == $cur_page)
                <li class="page-item active"><span class="page-link">{{$page}}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $page }}">{{$page}}</a></li>
            @endif
        @endfor

        @if($cur_page+1 <= $count_page)
            <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $cur_page+1 }}">Next</a></li>
        @else
            <li class="page-item active"><span class="page-link">Next</span></li>
        @endif
    </ul>
</nav>
