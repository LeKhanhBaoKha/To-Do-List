@if ($paginationLinks && $numberOfPage != 1)
@php
    $totalTodos = $todosWithPage['total'];
    $todosPerPage = $todosWithPage['per_page'];
    $totalPages = $todosWithPage['last_page'];
    $currentPage = $todosWithPage['current_page'];

    $pageButtonsToShow = 3;

    $startPage = max(1, $currentPage - $pageButtonsToShow);
    $endPage = min($totalTodos, $currentPage + $pageButtonsToShow);

    if ($currentPage == $totalPages - 2) {
        $endPage = $totalPages;
    }
    elseif ($currentPage == $totalPages - 1) {
        $endPage = $totalPages;
    }
    elseif ($currentPage == $totalPages) {
        $endPage = $totalPages;
    }
@endphp

<div>
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">

        @if ($currentPage > 1)
        <a href="indexPage?http://localhost:8008/api/serve/index?page={{$currentPage -1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0"><x-fas-angle-left class="w-[10px]"/></a>
        @endif

        @for ($i =$startPage; $i <= $endPage; $i++)
            <a href="indexPage?http://localhost:8008/api/serve/index?page={{$i}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300  {{$i == $currentPage ? 'bg-purple-500 text-white': '' }}">{{$i}}</a>
        @endfor

        @if ($currentPage < $totalPages)
        <a href="indexPage?http://localhost:8008/api/serve/index?page={{$currentPage +1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0"><x-fas-angle-right class="w-[10px]"/></a>
        @endif

    </nav>
  </div>
@endif
