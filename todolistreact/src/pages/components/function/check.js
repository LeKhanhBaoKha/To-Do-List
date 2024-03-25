import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCheck, faX } from '@fortawesome/free-solid-svg-icons'
import { useState } from 'react';
function Check(todo){
    const token = sessionStorage.getItem('token');

    const [ completedata, setCompletedata] = useState({
        id: todo['id'],
        state: 1,
    })

    const [incompletedata, setIncompletedata] = useState({
        id: todo['id'],
        state: 0
    })

    function handleComplete(event){
        event.preventDefault();
        console.log(1);
        const data ={
            method: 'PATCH',
            headers:{
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify(completedata)
        }
        console.log(data);

        fetch('http://localhost:8008/api/serve/update', data).then(response=>response.json()).then(data=>console.log(data)).catch(error => console.error(error));
    }

    function handleInComplete(event){
        event.preventDefault();
        console.log(0);
        const data ={
            method: 'PATCH',
            headers:{
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify(incompletedata)
        }
        console.log(data);
        
        fetch('http://localhost:8008/api/serve/update', data).then(response=>response.json()).then(data=>console.log(data)).catch(error => console.error(error));
    }
    if(todo['state'] == 0){
        return <>
        <button class="font-bold py-1 px-2 rounded bg-purple-500  hover:text-green-500 text-white mr-2 transition duration-[0.5s] ease-in-out" id={completedata.id}
        onClick={handleComplete}>
            <FontAwesomeIcon icon={faCheck} class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] " />
        </button>
        <div>
            <form class="w-[600px] m-auto px-4 py-4 hidden" action="" method="" id={`complete_form${todo['id']}`}>
            <input type="hidden" name="id" value={completedata.id} style={{display:'none'}}/>
                <input type="hidden" name="state" value={completedata.state} style={{display:'none'}}/>
            </form>
        </div>
        </> 
    }
    else{
        return <>
        <button class="font-bold py-1 px-2 rounded bg-purple-500  hover:text-red-500 text-white mr-2 transition duration-[0.5s] ease-in-out" id={incompletedata.id}
        onClick={handleInComplete}>
        <FontAwesomeIcon icon={faX} class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px]"/>
        </button>
        <div>
            <form class="w-[600px] m-auto px-4 py-4 hidden" action="" method="" id={`incomplete_form${todo['id']}`}>
            <input type="hidden" name="id" value={incompletedata.id} style={{display:'none'}}/>
                <input type="hidden" name="state" value={incompletedata.state} style={{display:'none'}}/>
            </form>
        </div>
        </>        
    }
}

export default Check