import { useEffect, useState } from "react"
import * as React from 'react';
import CircularProgress from '@mui/material/CircularProgress';
import Box from '@mui/material/Box';
import Check from "./function/check";
import Details from "./function/details";
import Edit from "./function/Edit";
import Delete from "./function/Delete";
import Paging from "./Pagination";
const Index = () =>{
    const [todos, setTodos] = useState(null);
    const token = sessionStorage.getItem('token');
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [data, setData] = useState(null);
    const [links, setLinks] = useState(null);
    const current_page = sessionStorage.getItem('current_page');

    const CheckWrapper = ({todo, fetchData})=>{
        const check = Check(todo, fetchData);
        return check
    };
    const DetailsWrapper = ({todo})=>{
        const details = Details(todo);
        return details;
    }
    const EditWrapper = ({todo, data, fetchData})=>{
        const edit = Edit(todo, data, fetchData);
        return edit;
    }
    const DeleteWrapper =({todo, fetchData})=>{
        const deleteButton = Delete(todo, fetchData);
        return deleteButton;
    }

    const PaginationWrapper = ({links, fetchData})=>{
        const pagination = Paging(links, fetchData);
        return pagination;
    }

    const fetchData = async(url)=>{
        setIsLoading(true);
        setError(null);
        try{
            const response = await fetch(url,{
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            if(!response.ok){
                throw new Error(`Api request failed with status ${response.status}`);
            }
            const responseData = await response.json();
            console.log('responseData', responseData);
            setTodos(responseData.data);
            setLinks(responseData);
        }catch(error){
            setError(error.message);
        }finally{
            setIsLoading(false);
        }
    }

    const fetchProjectsUsers = async()=>{
        try{
            const response = await fetch('http://localhost:8008/api/serve/createData',{
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            if(!response.ok){
                throw new Error(`Api request for projects failed with status ${response.status}`);
            }
            const responseData = await response.json();
            setData(responseData);

        }catch(error){
            setError(error.message);
        }
    }

    useEffect(()=>{
        sessionStorage.setItem('current_page', 'http://localhost:8008/api/serve/index');
        fetchData('http://localhost:8008/api/serve/index');
        fetchProjectsUsers();
        const timerId = setInterval(fetchData, 600000); // Update every 600 seconds (10 minute)
        // Cleanup function to clear the interval when the component unmounts
        return () => clearInterval(timerId);
    },[]);
    if (error) {
        return (
        <div class="container mx-auto flex items-center justify-center h-[80vh]">
            <p class="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Error: {error}</p>
        </div>);
      }

      if (!todos) {
        return (
        <div class="container mx-auto flex items-center justify-center h-[80vh]">
            <Box sx={{ display: 'flex' }}>
            <CircularProgress />
            </Box>
            <p class="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Loading</p>
        </div>);
      }
      console.log('links', links);
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
                            <option selected>{current_page}</option>
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
                            <th class="px-4 py-2 rounded-l-lg" >Todo name</th>
                            <th class="px-4 py-2 lg:table-cell">Project name</th>
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
                            <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-center w-[120px]">
                                    <p class="font-bold text-green-600 bg-green-50 rounded-lg">Complete</p>
                            </td>
                        ):(
                            <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-center w-[120px]">
                            <p class="font-bold text-blue-600 bg-blue-50 rounded-lg">In process</p>
                            </td>
                        )}

                        {/* belongsto */}
                        <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-justify">
                        {todo['user']['name']}
                        </td>

                        {/* timeLeft */}
                        <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-left">
                            {renderTimeLeft(todo)}
                        </td>

                        {/* function */}
                        <td class="box-border border-b-2 border-gray-150 px-4 py-2 rounded-r-lg">
                            <div className="flex justify-center">
                                {/* check button */}
                                <CheckWrapper todo={todo} fetchData={fetchData}/>
                                {/* end check button */}

                                {/* details */}
                                <DetailsWrapper todo={todo}/>

                                {/* edit */}
                                <EditWrapper todo={todo} data={data} fetchData={fetchData}/>

                                {/* delete */}
                                <DeleteWrapper todo={todo} fetchData={fetchData}/>
                            </div>
                        </td>
                    </tr>
                ))
            }
                        </tbody>
                    </table>

                    {/* Pagination */}
                    <div className="lg:w-[1500px] md:w-[800px] m-auto">
                        <PaginationWrapper links={links} fetchData={fetchData}/>
                    </div>
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

function renderTimeLeft(todo){
    if(todo.timeLeft == 0){
        return <>
            <p className="font-bold text-red-600 bg-red-50 rounded-lg text-center w-[80px] m-auto">Time's up</p>
        </>
    }else{
        if(todo.timeLeft <60){
            return <>{todo.timeLeft} minutes</>;
        }
        else if(todo.timeLeft < 1440){
            return <>
            {Math.floor(todo.timeLeft/60)} hours {todo.timeLeft%60} minutes
            </>
        }
        else{
            let days = Math.floor(todo.timeLeft/1440);
            let minutesAfterDay = todo.timeLeft - days*1440;
            let hours = Math.floor(minutesAfterDay/60);
            let minutes = minutesAfterDay - hours*60;

            const totalTimeLeft = [];
            if(days != 0){
                totalTimeLeft.push(`${days} days`)
            }
            if(hours != 0){
                totalTimeLeft.push(`${hours} hours`);
            }
            if(minutes != 0){
                totalTimeLeft.push(`${minutes} minutes`);
            }
            return <>{totalTimeLeft.join(' ')}</>;
        }
    }
}


export default Index