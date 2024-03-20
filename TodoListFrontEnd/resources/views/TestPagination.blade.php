@if ($paginationLinks && $numberOfPage != 1)
@php
    $totalTodos = $todosWithPage['total'];
    $todosPerPage = $todosWithPage['per_page'];
    $totalPages = $todosWithPage['last_page'];
    $currentPage = $todosWithPage['current_page'];

    $pageButtonsToShow = 3;

    $startPage = max(1, $currentPage - $pageButtonsToShow);
    $endPage = min($totalPages, $currentPage + $pageButtonsToShow);

@endphp
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">

        @if ($currentPage > 1)
            @if (strpos($todosWithPage['path'], 'completed'))
            <a href="indexPage?http://localhost:8008/api/serve/completed?page={{$currentPage -1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-l-lg"><x-fas-angle-left class="w-[10px]"/></a>
            @elseif(strpos($todosWithPage['path'], 'inprocess'))
            <a href="indexPage?http://localhost:8008/api/serve/inprocess?page={{$currentPage -1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-l-lg"><x-fas-angle-left class="w-[10px]"/></a>
            @elseif(strpos($todosWithPage['path'], 'search'))
            <a href="indexPage?http://localhost:8008/api/serve/search?search_box={{Session::get('search_box')}}&selection={{Session::get('selection')}}&page={{$currentPage -1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-l-lg"><x-fas-angle-left class="w-[10px]"/></a>
            @else
            <a href="indexPage?http://localhost:8008/api/serve/index?page={{$currentPage -1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-l-lg"><x-fas-angle-left class="w-[10px]"/></a>
            @endif
        @endif

        @for ($i =$startPage; $i <= $endPage; $i++)
            @if (strpos($todosWithPage['path'], 'completed') )
            <a href="indexPage?http://localhost:8008/api/serve/completed?page={{$i}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear {{$i == $currentPage ? 'bg-purple-500 text-white': '' }}">{{$i}}</a>
            @elseif(strpos($todosWithPage['path'], 'inprocess'))
            <a href="indexPage?http://localhost:8008/api/serve/inprocess?page={{$i}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear {{$i == $currentPage ? 'bg-purple-500 text-white': '' }}">{{$i}}</a>
            @elseif(strpos($todosWithPage['path'], 'search'))
            <a href="indexPage?http://localhost:8008/api/serve/search?search_box={{Session::get('search_box')}}&selection={{Session::get('selection')}}&page={{$i}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear {{$i == $currentPage ? 'bg-purple-500 text-white': '' }}">{{$i}}</a>
            @else
            <a href="indexPage?http://localhost:8008/api/serve/index?page={{$i}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear {{$i == $currentPage ? 'bg-purple-500 text-white': '' }}">{{$i}}</a>
            @endif
        @endfor

        @if ($currentPage < $totalPages)

        @if (strpos($todosWithPage['path'], 'completed'))
        <a href="indexPage?http://localhost:8008/api/serve/completed?page={{$currentPage +1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-r-lg"><x-fas-angle-right class="w-[10px]"/></a>
        @elseif(strpos($todosWithPage['path'], 'inprocess'))
        <a href="indexPage?http://localhost:8008/api/serve/inprocess?page={{$currentPage +1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-r-lg"><x-fas-angle-right class="w-[10px]"/></a>
        @elseif(strpos($todosWithPage['path'], 'search'))
        <a href="indexPage?http://localhost:8008/api/serve/search?search_box={{Session::get('search_box')}}&selection={{Session::get('selection')}}&page={{$currentPage +1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-r-lg"><x-fas-angle-right class="w-[10px]"/></a>
        @else
        <a href="indexPage?http://localhost:8008/api/serve/index?page={{$currentPage +1}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-purple-100 hover:text-black focus:z-20 focus:outline-offset-0 transition duration-300 ease-linear rounded-r-lg"><x-fas-angle-right class="w-[10px]"/></a>
        @endif
        @endif

    </nav>
@endif
