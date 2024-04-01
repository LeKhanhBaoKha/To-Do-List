import { useEffect, useState } from "react"
import * as React from "react";
import CircularProgress from "@mui/material/CircularProgress";
import Box from "@mui/material/Box";
import Check from "./function/check";
import Details from "./function/details";
import Edit from "./function/Edit";
import Delete from "./function/Delete";
import Paging from "./Pagination";
import Create from "./function/Create";
const Index = () =>{
    const [todos, setTodos] = useState(null);
    const token = sessionStorage.getItem("token");
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [data, setData] = useState(null);
    const [links, setLinks] = useState(null);

    const CheckWrapper = ({todo, fetchData})=>{
        const check = Check(todo, fetchData);
        return check;
    };
    const DetailsWrapper = ({todo})=>{
        const details = Details(todo);
        return details;
    };
    const EditWrapper = ({todo, data, fetchData})=>{
        const edit = Edit(todo, data, fetchData);
        return edit;
    };
    const DeleteWrapper =({todo, fetchData})=>{
        const deleteButton = Delete(todo, fetchData);
        return deleteButton;
    };

    const PaginationWrapper = ({links, fetchData})=>{
        const pagination = Paging(links, fetchData);
        return pagination;
    };

    const CreateWrapper = ({data, fetchData})=>{
        const create = Create(data, fetchData);
        return create;
    };

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
            console.log("responseData", responseData);
            setTodos(responseData.data);
            setLinks(responseData);
            
        }catch(error){
            setError(error.message);
        }finally{
            setIsLoading(false);
        }
    };




    const fetchProjectsUsers = async()=>{
        try{
            const response = await fetch("http://localhost:8008/api/serve/createData",{
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            if(!response.ok){
                throw new Error(`Api request htmlFor projects failed with status ${response.status}`);
            }
            const responseData = await response.json();
            setData(responseData);

        }catch(error){
            setError(error.message);
        }
    };

    function selectState(event){
        var url = event.target.value;
        fetchData(url);
    }

    const fetchInitialData = async () => {
        sessionStorage.setItem("current_page", "http://localhost:8008/api/serve/index");
        await fetchData("http://localhost:8008/api/serve/index");
        await fetchProjectsUsers();
      };
    

    useEffect(()=>{
        fetchInitialData();
        // const timerId = setInterval(fetchData, 600000); // Update every 600 seconds (10 minute)
        // // Cleanup function to clear the interval when the component unmounts
        // return () => clearInterval(timerId);

    },[]);
    if (error) {
        return (
        <div className="container mx-auto flex items-center justify-center h-[80vh]">
            <p className="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Error: {error}</p>
        </div>);
      }

      if (!todos) {
        return (
        <div className="container mx-auto flex items-center justify-center h-[80vh]">
            <Box sx={{ display: "flex" }}>
            <CircularProgress />
            </Box>
            <p className="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Loading</p>
        </div>);
      }

    return(
        <div className="index">
    <div className="mx-auto rounded-2xl border bg-white p-2 w-[85%] mb-4" id="index">
        {
            todos != null ?
            (
                <div className="w-full overflow-auto">
                    <div className="lg:w-[1500px] md:w-[800px] m-auto">
                        <div className="max-w-sm my-4 inline-block">
                            <label htmlFor="index_select" className="mb-2 block text-sm font-medium text-gray-900">Select an option</label>
                            <select id="index_select" className="block w-full rounded-lg border border-gray-400 bg-gray-50 p-2.5 text-sm text-gray-600 focus:border-purple-400 focus:ring-purple-400" onChange={(e)=>selectState(e)}>
                            <option defaultValue="http://localhost:8008/api/serve/index">All</option>
                            <option defaultValue="http://localhost:8008/api/serve/completed">Completed</option>
                            <option defaultValue="http://localhost:8008/api/serve/inprocess">In process</option>
                            </select>
                        </div>

                        <div className="inline-block ml-2">
                            <a href="todaytask" className=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out border-gray-300 border hover:border-none ">Today&apos;s task</a>
                        </div>

                        <div className="inline-block ml-2">
                            <a className="hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out border-gray-300 border hover:border-none ">
                                <label htmlFor="create" className="cursor-pointer rounded">Create</label>
                            </a>
                        </div>
                        
                      
                        
                    </div>

                    <table className="table-auto lg:w-[1500px] md:w-[800px] m-auto mb-5">
                        <thead>
                        <tr className="bg-gradient-to-br from-pink-50 to-indigo-100">
                            <th className="px-4 py-2 rounded-l-lg" >Todo name</th>
                            <th className="px-4 py-2 lg:table-cell">Project name</th>
                            <th className="px-4 py-2">state </th>
                            <th className="px-4 py-2">Belongs to</th>
                            <th className="px-4 py-2">Time left</th>

                            <th className="px-4 py-2 rounded-r-lg">function</th>
                        </tr>
                        </thead>
                        <tbody>

            {
                todos.map((todo, index)=>
                (
                    <tr key={todo["id"]} className="hover:bg-green-50 transition duration-300 ease-in-out rounded-xl">
                        {/* name */}
                        <td className="box-border border-b-2 border-gray-150  px-4 py-2 text-justify rounded-l-lg">{todo["name"]}</td>

                        {/* projectname */}
                        <td className="box-border border-b-2 border-gray-150  px-4 py-2 text-justify rounded-l-lg">{todo["project"]["name"]}</td>

                        {/* state */}
                        {todo["state"] == 1?
                        (
                            <td className="box-border border-b-2 border-gray-150 px-4 py-2 text-center w-[120px]">
                                    <p className="font-bold text-green-600 bg-green-50 rounded-lg">Complete</p>
                            </td>
                        ):(
                            <td className="box-border border-b-2 border-gray-150 px-4 py-2 text-center w-[120px]">
                            <p className="font-bold text-blue-600 bg-blue-50 rounded-lg">In process</p>
                            </td>
                        )}

                        {/* belongsto */}
                        <td className="box-border border-b-2 border-gray-150 px-4 py-2 text-justify">
                        {todo["user"]["name"]}
                        </td>

                        {/* timeLeft */}
                        <td className="box-border border-b-2 border-gray-150 px-4 py-2 text-left">
                            {renderTimeLeft(todo)}
                        </td>

                        {/* function */}
                        <td className="box-border border-b-2 border-gray-150 px-4 py-2 rounded-r-lg">
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

                    <CreateWrapper data={data} fetchData={fetchData}/>
                    {/* Pagination */}
                    <div className="lg:w-[1500px] md:w-[800px] m-auto z-[1000] mb-4">
                        <PaginationWrapper links={links} fetchData={fetchData}/>
                    </div>
                </div>
            )
            :
            (
            <div className="container mx-auto flex items-center justify-center h-[80vh]">
                <p className="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Nothing to do, let&apos;s chill</p>
            </div>
            )
        }
        </div>
        </div>
       
    )
}

function renderTimeLeft(todo){
    if(todo.timeLeft == 0){
        return <>
            <p className="font-bold text-red-600 bg-red-50 rounded-lg text-center w-[80px] m-auto">Time&apos;s up</p>
        </>;
    }else{
        if(todo.timeLeft <60){
            return <>{todo.timeLeft} minutes</>;
        }
        else if(todo.timeLeft < 1440){
            return <>
            {Math.floor(todo.timeLeft/60)} hours {todo.timeLeft%60} minutes
            </>;
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
            return <>{totalTimeLeft.join(" ")}</>;
        }
    }
}



export default Index