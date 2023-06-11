@if ($paginator->hasPages())
    <ul class="pagination pagination-sm float-right">
        <li class="{{ $paginator->currentPage() == 1 ? ' disabled' : '' }} page-item">
            <a class=" page-link " href="{{ $paginator->url(1) }}" aria-label="Previous">
                &laquo;
            </a>
        </li>
        @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled page-item" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active page-item" aria-current="page">
                                <a href="#" class="page-link "><span>{{ $page }}</span></a></li>
                        @else
                            <li class="page-item"><a class="page-link " href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        <li class="{{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }} page-item">
            <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" class="page-link" aria-label="Next">
                &raquo;
            </a>
        </li>
    </ul>
@endif
