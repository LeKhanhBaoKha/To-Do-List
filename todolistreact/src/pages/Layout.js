import { Outlet } from "react-router-dom";

const Layout = () =>{
    return(<>
    <div className="roboto-regular h-screen bg-gradient-to-br from-pink-50 to-indigo-100 overflow-auto">
    <nav class="bg-gray-800 mb-5">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                            alt="BaoKha-TodoList"/>
                    </div>
                    <div class="sm:ml-6 sm:block items-center">
                        <div class="flex space-x-4 ">
                        <p class=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Hello, Have you checked your to-do list?</p>
                        <a href="register" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out text-gray-100">Register</a>
                        
                        <a href="login" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out  text-gray-100">Login</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <Outlet />


    <footer class="bg-gray-800">
        <p class="text-gray-300  rounded-md px-3 py-2 text-sm font-medium">@copy right: lekhanhbaokha@gmail.com</p>
    </footer>

    </div>
    
    </>)
}
export default Layout;