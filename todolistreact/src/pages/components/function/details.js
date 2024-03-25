import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCheck, faPenToSquare, faX } from '@fortawesome/free-solid-svg-icons'
function Details(todo){
    return <>
        <button class={`${todo['id']}-modal font-bold py-1 px-2 rounded bg-purple-500  text-white mr-2 details-button`} id="dt-button" >
        <label for="{{$todo['id']}}-modal" class="cursor-pointer rounded">
            <FontAwesomeIcon icon={faPenToSquare} class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] details"/>
        </label>
        </button>
    </>
}