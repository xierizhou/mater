@if ($paginator->hasPages())
    <div class="page">
        <div>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="prev layui-disabled">&lt;&lt;</a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="prev">&lt;&lt;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="layui-laypage-spr">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="current">{{ $page }}</span>
                        @else
                            <a class="num" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;&gt;</a>
            @else
                <a class="next layui-disabled">&gt;&gt;</a>
            @endif
        </div>
    <div>
@endif
