<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @notifyCss
    @vite('resources/css/app.css')
    <tittle>
        @yield('tittle')
    </tittle>

    <style>
        @yield('css')
        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        button {
            transition: 0.5s;
        }

        .roboto-regular {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .dropdown:hover .dropdown-menu {
         display: block;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

</head>

<body class="roboto-regular">
    <nav class="bg-gray-800 mb-5">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                            alt="Your Company">
                    </div>
                    <div class="sm:ml-6 sm:block items-center">
                        <div class="flex space-x-4 ">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            @if (strpos(url()->current(), 'login'))
                            <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checked
                                your to-do list?</p>
                            <a href="register" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                            @if (strpos(url()->current(), 'register'))
                            bg-gray-900 text-white
                            @else
                            text-gray-300
                            @endif
                        ">Register</a>
                            @elseif (strpos(url()->current(), 'register'))
                            <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checked
                                your to-do list?</p>
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
                    " aria-current="page">
                                @if ($user == 1)
                                Hello Admin
                                @else
                                To Do List
                                @endif
                            </a>

                            <a class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                        @if (strpos(url()->current(), 'create'))
                        bg-gray-900 text-white
                        @else
                        text-gray-300
                        @endif
                    ">
                                <label for="create" class="cursor-pointer rounded">Create</label>
                            </a>

                            {{-- check if the user is login or not --}}

                            @if ($is_loggedIn)
                            {{-- if they are, change the log in button to log out --}}
                            <a class="transition duration-300 ease-in-out text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Log
                                out</a>

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
                @include('create')
                <div class="notification-bell ">
                    <div class="dropdown inline-block relative">
                        <button class=" text-white font-semibold py-2 px-4 rounded inline-flex items-center text-left">
                          <span class="mr-1"><x-fas-bell class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] text-white"/></span>
                          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                        </button>
                        <ul class="dropdown-menu absolute hidden text-gray-700 pt-1 text-left">
                          <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">One</a></li>
                        </ul>
                      </div>
                </div>

    </nav>
    <div>
        @yield('content')
    </div>
    <footer class="bg-gray-800">
        <p class="text-gray-300  rounded-md px-3 py-2 text-sm font-medium">@copy right: lekhanhbaokha@gmail.com</p>
    </footer>
</body>

</html>
