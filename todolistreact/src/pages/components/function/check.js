import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheck, faX } from "@fortawesome/free-solid-svg-icons";
import { useState } from "react";
import React from "react";

function Check(todo, fetchData){
    const token = sessionStorage.getItem("token");
    const current_page = sessionStorage.getItem("current_page");

    const [completedata, setCompletedata] = useState({
        id: todo ? todo.id : "",
        state: 1,
    })

    const [incompletedata, setIncompletedata] = useState({
        id: todo ? todo.id : "",
        state: 0
    })

    function handleComplete(event){
        event.preventDefault();
        const data ={
            method: "PATCH",
            headers:{
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`,
            },
            body: JSON.stringify(completedata)
        }
        fetch("http://localhost:8008/api/serve/update", data).then(response=>response.json()).catch(error => console.error(error));
        fetchData(current_page);
    }

    function handleInComplete(event){
        event.preventDefault();
        const data ={
            method: "PATCH",
            headers:{
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`,
            },
            body: JSON.stringify(incompletedata)
        }
        fetch("http://localhost:8008/api/serve/update", data).then(response=>response.json()).catch(error => console.error(error));
        fetchData(current_page);
    }

    if(todo["state"] == 0){
        return (
        <>
        <button className="font-bold py-1 px-2 rounded bg-purple-500  hover:text-green-500 text-white mr-2 transition duration-[0.5s] ease-in-out" id={completedata.id}
        onClick={(e)=>{handleComplete(e)}}>
            <FontAwesomeIcon icon={faCheck} className="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] " />
        </button>
        <div>
            <form className="w-[600px] m-auto px-4 py-4 hidden" action="" method="" id={`complete_form${todo["id"]}`}>
            <input type="hidden" name="id" defaultValue={completedata.id} style={{display:"none"}}/>
                <input type="hidden" name="state" defaultValue={completedata.state} style={{display:"none"}}/>
            </form>
        </div>
        </>
        )
    }
    else{
        return (
        <>
        <button className="font-bold py-1 px-2 rounded bg-purple-500  hover:text-red-500 text-white mr-2 transition duration-[0.5s] ease-in-out" id={incompletedata.id}
        onClick={(e)=>{handleInComplete(e)}}>
        <FontAwesomeIcon icon={faX} className="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px]"/>
        </button>
        <div>
            <form className="w-[600px] m-auto px-4 py-4 hidden" action="" method="" id={`incomplete_form${todo["id"]}`}>
            <input type="hidden" name="id" defaultValue={incompletedata.id} style={{display:"none"}}/>
                <input type="hidden" name="state" defaultValue={incompletedata.state} style={{display:"none"}}/>
            </form>
        </div>
        </>
        )     
    }
}

export default Check