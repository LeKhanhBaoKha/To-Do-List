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

<body class="roboto-regular h-screen bg-gradient-to-br from-pink-50 to-indigo-100">
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
                            <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checked your to-do list?</p>

                                <a href="register" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                                @if (strpos(url()->current(), 'register'))
                                bg-gray-900 text-white
                                @else
                                text-gray-300
                                @endif
                                ">Register</a>

                            @elseif (strpos(url()->current(), 'register'))

                                <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checkedyour to-do list?</p>
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

                            <a class="hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out
                            @if (strpos(url()->current(), 'create'))
                            bg-gray-900 text-white
                            @else
                            text-gray-300
                            @endif">
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
                            @endif">Login</a>
                            @endif

                            @endif
                        </div>
                    </div>

                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                @include('create')
                @if (!strpos(url()->current(), 'login') && !strpos(url()->current(), 'register') )
                <div class="search {{$is_loggedIn? "block" : "hidden"}}">
                    <form class="flex gap-x-1" method="get" action="search">
                        @csrf
                        <div class="relative w-[350px]">
                          <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                          </div>
                          <input type="search" id="search_box" name="search_box" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500" placeholder="Search" required />
                          <button type="submit" class="absolute bottom-[0.340rem] end-2.5 rounded-lg bg-purple-600 mt-2 px-4 py-1 text-sm font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Search</button>
                        </div>
                        <select id="selection" name="selection" class="block w-[120px] rounded-lg border border-gray-400 bg-gray-50 p-2 text-sm text-gray-600 focus:border-purple-400 focus:ring-purple-400">
                            @if($userinfo['is_admin'] == 1)
                                <option name='user_name' value="user_name" selected>User name</option>
                            @endif
                            @if($userinfo['is_admin'] == 0)
                                <option name='task_name' value="task_name" selected>Task name</option>
                            @else
                                <option name='task_name' value="task_name">Task name</option>
                            @endif
                            <option name='project_name' value="project_name">Project name</option>
                        </select>

                    </form>
                </div>
                @endif
    </nav>
    <div class=" mx-auto rounded-2xl border bg-white p-2 shadow-sm {{strpos(url()->current(), 'login')||strpos(url()->current(), 'register')? 'w-[600px] mt-[100px]':'w-[85%]'}}">
        @yield('content')
    </div>
    <footer class="bg-gray-800">
        <p class="text-gray-300  rounded-md px-3 py-2 text-sm font-medium">@copy right: lekhanhbaokha@gmail.com</p>
    </footer>
</body>

</html>
