@if ($paginationLinks && $numberOfPage != 1)

    <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
          @foreach ($paginationLinks as $link)

          @if ($link['label']  == 'Next &raquo;' && $link['url'] == null)
            <a href="indexPage?{{$link['url']}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 opacity-50 cursor-not-allowed" disabled><x-fas-angle-right class="w-[10px]"/></a>
          @elseif ($link['label']  == 'Next &raquo;')
            <a href="indexPage?{{$link['url']}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"><x-fas-angle-right class="w-[10px]"/></a>
          @elseif ($link['label'] == '&laquo; Previous' && $link['url'] == null)
            <a href="indexPage?{{$link['url']}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 opacity-50 cursor-not-allowed" disabled><x-fas-angle-left class="w-[10px]"/></a>
          @elseif ($link['label'] == '&laquo; Previous')
            <a href="indexPage?{{$link['url']}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"><x-fas-angle-left class="w-[10px]"/></a>
          @else
          <a href="indexPage?{{$link['url']}}" aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">{{ $link['label'] }}</a>
          @endif

          @endforeach
        </nav>
      </div>
@endif
