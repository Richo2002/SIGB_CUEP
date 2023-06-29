@if ($paginator->hasPages())
<span>
    Affichage de {{ $paginator->firstItem() }} à {{ $paginator->lastItem() }} sur {{ $paginator->total() }} entrées
</span>

<nav aria-label="Page navigation" id="navigation">
    <ul class="pagination">
        {{-- First Page Link --}}
        @if ( ! $paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" wire:click.prevent="gotoPage(1)"><<</a>
            </li>
            @if($paginator->currentPage() > 2)
                {{-- Previous Page Link --}}
                <li class="page-item">
                    <a class="page-link" wire:click.prevent="previousPage"><</a>
                </li>
            @endif
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    {{-- Use three dots when current page is greater than 3 --}}
                    @if ($paginator->currentPage() > 3 && $page === 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif

                    {{-- Show active page two pages before and after it --}}
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2)
                        <li class="page-item">
                            <a class="page-link" wire:click.prevent="gotoPage({{$page}})">{{ $page }}</a>
                        </li>
                    @endif

                    {{-- Use three dots when current page is away from end --}}
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2  && $page === $paginator->lastPage() - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            @if($paginator->lastPage() - $paginator->currentPage() >= 2)
                <li class="page-item">
                    <a class="page-link" wire:click.prevent="nextPage">></a>
                </li>
            @endif
            <li class="page-item">
                <a class="page-link" wire:click.prevent="gotoPage({{ $paginator->lastPage() }})">>></a>
            </li>
        @endif
    </ul>
</nav>
@endif

