import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faGear } from '@fortawesome/free-solid-svg-icons'
function Edit(todo, data){
    if(data != null){
    const {projects, users} = data;

    return(<>
        <button class="font-bold py-1 px-2 rounded bg-purple-500  text-white mr-2 editButton">
            <label for={[todo['id'],'-editmodal'].join('')}  class="cursor-pointer rounded">
            <FontAwesomeIcon icon={faGear} class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] gear"/>
            </label>
        </button>
        <div class="z-10">
        <input type="checkbox" id={[todo['id'],'-editmodal'].join('')} class="peer fixed appearance-none opacity-0" />
        <label for={[todo['id'],'-editmodal'].join('')}  class="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
        <label class="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-[80%] overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" for="">
            <form class="w-[600px] m-auto px-4 py-4" action="update" method="post">
                <input type="hidden" name="id" value={todo['id']} style={{display:'none'}}/>
    
                <div class="flex md:items-center h-[50px] justify-between">
                    <div class="w-[10%] h-full pb-14">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="state">
                            State:
                          </label>
                    </div>
                    <div class="w-[80%] flex pb-3 gap-4">
                        <div class="flex items-center mb-4">
                            <input type="radio" name="state" value="0" class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="state-option-1" aria-describedby="state-option-1"  
                            id={['inprocess',todo['id']].join('')}
                            />
                            <label for="state-option-1" class="text-sm font-medium text-gray-900 ml-2 block" >
                            In progress
                            </label>
                            {addChecked(todo['state'],['inprocess',todo['id']].join(''))}
                        </div>
                        <div class="flex items-center mb-4">
                            <input type="radio" name="state" value="1" class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="state-option-2" aria-describedby="state-option-2" 
                            id={['complete',todo['id']].join('')}
                            />
                            <label for="state-option-2" class="text-sm font-medium text-gray-900 ml-2 block">
                            Complete
                            </label>
                            {addChecked(todo['state'],['complete',todo['id']].join(''))}
                        </div>
                    </div>
                </div>
    
                <div class="flex items-center">
                  <div class="w-full">
                    <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded w-full" type="submit">
                      Submit
                    </button>
                  </div>
                </div>
              </form>
        </label>
        </label>
        </div>
        </>)
    }


}
export default Edit


function addChecked(todoStat, todoId){
  const input = document.getElementById(todoId);
  if(todoId.includes('inprocess') && input != null){
    if(todoStat == 0)
      input.checked =true;
  }else{
    if(todoStat == 1)
      input.checked =true;
  }
}