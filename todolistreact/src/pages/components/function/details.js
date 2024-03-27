import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faPenToSquare } from '@fortawesome/free-solid-svg-icons'
import { format } from 'date-fns';
import './Details.css';
function Details(todo){

    function animatedDetail(event){
        const detailButton = document.getElementById([todo['id'],"dt-button"].join(''));
        detailButton.addEventListener('mouseover', () => {
            // Add a class to the details element
            const detailIcon = document.getElementById([todo['id'],"dt-icon"].join(''));
            detailIcon.classList.add('animated');
        });
    }

    return <>
        <button class={`${todo['id']}-modal font-bold py-1 px-2 rounded bg-purple-500  text-white mr-2 details-button`} id={[todo['id'],"dt-button"].join('')}

         onMouseOver={(e)=>animatedDetail(e)}>
        <label for={[todo['id'],'-modal']} class="cursor-pointer rounded">
            <FontAwesomeIcon icon={faPenToSquare} class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] details " id={[todo['id'],"dt-icon"].join('')}/>
        </label>
        </button>

        <div class="z-10">
        <input type="checkbox" id={[todo['id'],'-modal']} class="peer fixed appearance-none opacity-0" />
        <label for={[todo['id'],'-modal']} class="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
        <label class="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-lg overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" for="">
            <h3 class="py-2 text-lg font-bold text-center">Name: {todo["name"]}</h3>
            <p class="py-1">Description: {todo['description']}</p>
            <div class="flex">
                <label for="" class="py-1">State:&nbsp;</label>
                {todo['state'] == 0 ?
                (<p class="py-1 text-blue-500 font-bold">In process</p>):
                (<p class="py-1 text-green-500 font-blod">Complete</p>)}    
            </div>
            <p class="py-1">Project: {todo['project']['name']}</p>
            <p class="py-1">Belongs to: {todo['user']['name']}</p>
            <p class="py-1">Starting date: {format(todo['created_at'], 'MMMM do yyyy, h:mm:ss a')}</p>
            <p class="py-1">Deadline: {format(todo['deadline'], 'MMMM do yyyy, h:mm:ss a')}</p>
        </label>
        </label>
        </div>
    </>
}

export default Details