import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faGear } from '@fortawesome/free-solid-svg-icons'
function Edit(todo, data){
    if(data != null){
    const {projects} = data;
    return(<>
        <div class="flex items-center mb-6">
            <div class="w-1/5">
                <label class="block text-gray-500 font-bold text-left " for="project_id">
                Project name:
                </label>
            </div>
            <div class="w-4/5">
                <select name="project_id" id="project_id">
                    <option value={todo['project']['id']}>{todo['project']['name']}</option>
                    <ProjectsSelect data={projects} todoProjectName={todo['project']['name']}/>
                </select>
            </div>
        </div>
        </>)
    }


}
export default Edit

function ProjectsSelect(projects){
    projects['data'].map((project,index)=>{
        if(projects['todoProjectName'] == project['Name'])
        {
            return null;
        }
        else{
            return  (<option value={project['id']}>{project['name']}</option>)
        }
    })
}
