<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center" data-pagination>
        @if($count_page < 10)
            @if($cur_page-1 > 0)
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $cur_page-1 }}">Previous</a></li>
            @else
                <li class="page-item active"><span class="page-link">Previous</span></li>
            @endif

            @for($page=1; $page <= $count_page; $page++)
                @if($page == $cur_page)
                    <li class="page-item active"><span class="page-link">{{$page}}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $page }}{{isset($filter)?$filter:''}}">{{$page}}</a></li>
                @endif
            @endfor

            @if($cur_page+1 <= $count_page)
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $cur_page+1 }}{{isset($filter)?$filter:''}}">Next</a></li>
            @else
                <li class="page-item active"><span class="page-link">Next</span></li>
            @endif
        @else

            @if($cur_page-1 > 0)
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $cur_page-1 }}{{isset($filter)?$filter:''}}">Previous</a></li>
            @else
                <li class="page-item active"><span class="page-link">Previous</span></li>
            @endif

            @if($cur_page > 5)
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page=1">1</a></li>
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page=2">2</a></li>
                <li class="page-item"><span class="page-link">...</span></li>

                @if($count_page - $cur_page > 5)
                    <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{$cur_page-1}}{{isset($filter)?$filter:''}}">{{$cur_page-1}}</a></li>
                    <li class="page-item active"><span class="page-link">{{$cur_page}}</span></li>
                    <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{$cur_page+1}}{{isset($filter)?$filter:''}}">{{$cur_page+1}}</a></li>
                    <li class="page-item"><span class="page-link">...</span></li>
                    <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{$count_page-1}}{{isset($filter)?$filter:''}}">{{$count_page-1}}</a></li>
                    <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{$count_page}}{{isset($filter)?$filter:''}}">{{$count_page}}</a></li>
                @else
                    @for($page=6; $page >= 1; $page--)
                        @if($count_page-$page == $cur_page)
                            <li class="page-item active"><span class="page-link">{{$cur_page}}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $count_page-$page }}{{isset($filter)?$filter:''}}">{{$count_page-$page}}</a></li>
                        @endif
                    @endfor
                @endif

            @else
                @for($page=1; $page <= 6; $page++)
                    @if($page == $cur_page)
                        <li class="page-item active"><span class="page-link">{{$page}}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $page }}{{isset($filter)?$filter:''}}">{{$page}}</a></li>
                    @endif
                @endfor
                <li class="page-item"><span class="page-link">...</span></li>
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{$count_page-1}}{{isset($filter)?$filter:''}}">{{$count_page-1}}</a></li>
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{$count_page}}{{isset($filter)?$filter:''}}">{{$count_page}}</a></li>
            @endif


            @if($cur_page+1 < $count_page)
                <li class="page-item"><a class="page-link" href="/dbEditor/{{$page_name}}?page={{ $cur_page+1 }}{{isset($filter)?$filter:''}}">Next</a></li>
            @else
                <li class="page-item active"><span class="page-link">Next</span></li>
            @endif
        @endif
    </ul>
</nav>
