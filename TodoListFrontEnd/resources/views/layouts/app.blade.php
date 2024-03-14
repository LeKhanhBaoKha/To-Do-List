<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <tittle>
    @yield('tittle')
  </tittle>
  <style>
    @yield('css')
    footer{
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        text-align: center;
    }
    button{
        transition: 0.5s;
    }
    .roboto-regular {
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-style: normal;
    }
  </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>
<body class="roboto-regular">
    <nav class="bg-gray-800 mb-5">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
          <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
              <!-- Mobile menu button-->
              <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                <span class="absolute -inset-0.5"></span>
                <span class="sr-only">Open main menu</span>
                <!--
                  Icon when menu is closed.

                  Menu open: "hidden", Menu closed: "block"
                -->
                <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <!--
                  Icon when menu is open.

                  Menu open: "block", Menu closed: "hidden"
                -->
                <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
              <div class="flex flex-shrink-0 items-center">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
              </div>
              <div class="sm:ml-6 sm:block items-center">
                <div class="flex space-x-4 ">
                  <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                  @if (strpos(url()->current(), 'login'))
                    <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checked your to-do list?</p>
                    <a href="register" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                            @if (strpos(url()->current(), 'register'))
                            bg-gray-900 text-white
                            @else
                            text-gray-300
                            @endif
                        ">Register</a>
                    @elseif (strpos(url()->current(), 'register'))
                    <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checked your to-do list?</p>
                    <a href="register" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                            @if (strpos(url()->current(), 'register'))
                            bg-gray-900 text-white
                            @else
                            text-gray-300
                            @endif
                        ">Register</a>
                        <a href="login" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                            @if (strpos(url()->current(), 'login'))
                            bg-gray-900 text-white
                            @else
                            text-gray-300
                            @endif
                        ">Login</a>
                  @else
                    <a href="index" class="hover:bg-gray-700 hover:text-white text-gray-300 rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                    @if (strpos(url()->current(), 'index'))
                    bg-gray-900 text-white
                    @else
                    text-gray-300
                    @endif
                    " aria-current="page" >
                        @if ($user == 1)
                            Hello Admin
                        @else
                            To Do List
                        @endif
                    </a>
                    <a href="create" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                        @if (strpos(url()->current(), 'create'))
                        bg-gray-900 text-white
                        @else
                        text-gray-300
                        @endif
                    ">Create</a>

                    {{-- check if the user is login or not --}}

                    @if ($is_loggedIn)
                    {{-- if they are, change the log in button to log out --}}
                    <a href="#" class="transition duration-300 ease-in-out text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Log out</a>

                    {{-- logout form --}}
                        <form action="logout" method="post" class="hidden" id="logout-form">@csrf</form>

                    @else
                        {{-- if they are not, keep the log in button --}}
                        <a href="login" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                            @if (strpos(url()->current(), 'login'))
                            bg-gray-900 text-white
                            @else
                            text-gray-300
                            @endif
                        ">Login</a>

                    @endif
                  @endif
                </div>
              </div>
            </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
          <div class="space-y-1 px-2 pb-3 pt-2">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Team</a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Calendar</a>
          </div>
        </div>
      </nav>
      <div>
        @yield('content')
      </div>
      <footer class="bg-gray-800"><p class="text-gray-300  rounded-md px-3 py-2 text-sm font-medium">@copy right: lekhanhbaokha@gmail.com</p></footer>
</body>
</html>
