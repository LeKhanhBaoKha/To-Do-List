import { faTrashCan } from "@fortawesome/free-solid-svg-icons"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"
import React from "react";
function Delete(todo, fetchData){
    const token = sessionStorage.getItem('token');
    const current_page = sessionStorage.getItem('current_page');

    function closeDelModal(){
        const delModal = [todo['id'],'-delmodal'].join('');
        const closeButtons = document.querySelectorAll('.close-modal');
        closeButtons.forEach(function (button) {
         button.addEventListener('click', function () {
           document.getElementById(delModal).checked = false;
         });
       });
    }

    function deleteTodo(event){
        event.preventDefault();
        const id = {id:todo['id']};
        const dataToSend = {
            method: 'DELETE',
            headers:{
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify(id)
        }
        fetch('http://localhost:8008/api/serve/delete', dataToSend).then(response=>response.json()).catch(error => console.error(error));
        fetchData(current_page);
    }


    return(<>
    <button className={[[todo['id'],'-delmodal'].join(''), "font-bold py-1 px-2 rounded bg-red-500 hover:bg-red-50 hover:text-red-500 text-white transition duration-[0.5s] ease-in-out" ].join(' ')} id="del-button" onClick={(e)=>{closeDelModal(e)}}>
        <label htmlFor={[todo['id'],'-delmodal'].join('')}  className={[[todo['id'],'-delmodal'].join(''),'cursor-pointer rounded'].join(' ')}>
            <FontAwesomeIcon icon={faTrashCan}  className={[[todo['id'],'-delmodal'].join(''),"sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px]"].join(' ')}/>
        </label>
    </button>

    <div className="">
    <input type="checkbox" id={[todo['id'],'-delmodal'].join('')} className="peer fixed appearance-none opacity-0" />
    <label htmlFor={[todo['id'],'-delmodal'].join('')} className="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
    <label className="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-lg overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" htmlFor="">
        <h3 className="text-lg font-bold text-center">Warning!</h3>
        <p className="py-4">Are you sure you want to delete this task?</p>
        <div className="flex justify-around">
            <button type="button" className="close-modal bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-4">
                Close
            </button>
            <form method="" action="" onSubmit={(e)=>deleteTodo(e)}>
                <input name="id" id="id" value={todo['id']} className="hidden"></input>
                <button className="font-bold py-2 px-4 rounded bg-red-500 hover:bg-red-400 text-white" type="submit">
                    <p>Delete</p>
                </button>
            </form>
        </div>
    </label>
    </label>
    </div>
    </>)
}

export default Delete