import axios from "axios"
import { useEffect, useState } from "react"

const Index = () =>{
    const [todos, setTodos] = useState('');
    const token = sessionStorage.getItem('token');
    useEffect(()=>{
        axios.get('http://localhost:8008/api/serve/index',{
            headers:{
                Authorization: `Bearer ${token}`
            }
        }).then(response =>{ 
            setTodos(response.data.data);
            console.log(todos);
        }).catch((error) =>{
            console.log(error);
        })
    },[]);

    console.log(todos);

    return(
        <div className="mx-auto rounded-2xl border bg-white p-2 w-[85%]">
        {
            todos != null ?
            (
                <div class="w-full overflow-auto">
                    <div class="lg:w-[1500px] md:w-[800px] m-auto">
                        <div class="max-w-sm my-4 inline-block">
                            <label for="index_select" class="mb-2 block text-sm font-medium text-gray-900">Select an option</label>
                            <select id="index_select" class="block w-full rounded-lg border border-gray-400 bg-gray-50 p-2.5 text-sm text-gray-600 focus:border-purple-400 focus:ring-purple-400" onchange="navigateTo()">
                            <option selected>Choose state</option>
                            <option value="http://127.0.0.1:8000/api/index">All</option>
                            <option value="http://127.0.0.1:8000/api/completed">Completed</option>
                            <option value="http://127.0.0.1:8000/api/inprocess">In process</option>
                            </select>
                        </div>
                        
                        <div class="inline-block ml-2">
                            <a href="todaytask" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out border-gray-300 border hover:border-none ">Today's task</a>
                        </div>
                    </div>     

                    <table class="table-auto lg:w-[1500px] md:w-[800px] m-auto mb-5">
                        <thead>
                        <tr class="bg-gradient-to-br from-pink-50 to-indigo-100">
                            <th class="px-4 py-2 rounded-l-lg" >Todo name of </th>
                            <th class="px-4 py-2 hidden lg:table-cell">Project name</th>
                            <th class="px-4 py-2">state </th>
                            <th class="px-4 py-2 {{$userinfo['is_admin'] == 1 ? '':'hidden'}}">Belongs to</th>
                            <th class="px-4 py-2">Time left</th>
                        
                            <th class="px-4 py-2 rounded-r-lg">function</th>
                        </tr>
                        </thead>
                        <tbody>

{    
    todos.map((todo, index)=>
    (
        <tr class="hover:bg-green-50 transition duration-300 ease-in-out rounded-xl">
            {/* name */}
            <td class="box-border border-b-2 border-gray-150  px-4 py-2 text-justify rounded-l-lg">{todo['name']}</td>

            {/* projectname */}
            <td class="box-border border-b-2 border-gray-150  px-4 py-2 text-justify rounded-l-lg">{todo['project']['name']}</td>

            {/* state */}
            {todo['state'] == 1?
            (
                <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-center	">
                        <p class="font-bold text-green-600 bg-green-50 rounded-lg">Complete</p>
                </td>
            ):(
                <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-center	">
                <p class="font-bold text-blue-600 bg-blue-50 rounded-lg">In process</p>
                </td>
            )}
        
            {/* belongsto */}
            <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-justify">
              {todo['user']['name']}
            </td>

            {/* timeLeft */}
            {/* <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-left">
                {todo['timeLeft']['days'] == 0 && todo['timeLeft']['hours'] == 0 && todo['timeLeft']['minutes'] == 0 ? 
                (
                    <p class="font-bold text-red-600 bg-red-50 rounded-lg text-center w-[80px] m-auto">Time's up</p>
                ):(
                    <p class="font-bold bg-red-50 rounded-lg text-center w-[80px] m-auto">Time's up</p>
                )}
            </td> */}
        </tr>
    ))
}
                        </tbody>
                    </table>
                </div>
            )
            :
            (
                <div class="container mx-auto flex items-center justify-center h-[80vh]">
                <p class="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Nothing to do, let's chill</p>
            </div>
            )
        }
        </div>
    )
}

export default Index