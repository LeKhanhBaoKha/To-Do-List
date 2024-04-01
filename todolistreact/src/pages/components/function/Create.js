import React, { useEffect, useState } from "react";
function Create(data, fetchData){
    const token = sessionStorage.getItem("token");
    const current_page = sessionStorage.getItem("current_page");
    const [pu, setPu] = useState(null);
    const [createData, setCreateData] = useState({
        name:null,
        description:null,
        project_id:null,
        user_id:null,
        deadline:null,
    }); 


    useEffect(()=>{
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
                setPu(responseData);
    
            }catch(error){
                console.log("create error:",error.message);
            }
        };
        fetchProjectsUsers();
    },[]);
    console.log('pu', pu);

    function handleCreate(event){
        event.preventDefault();
        console.log("createData",createData);
        const dataToSend = {
            method: "POST",
            headers:{
              "Content-Type": "application/json",
              "Authorization": `Bearer ${token}`,
            },
            body: JSON.stringify(createData)
          };
          fetch("http://localhost:8008/api/serve/store", dataToSend).then(response=>response.json()).then((response)=>console.log(response)).catch(error => console.error(error));
          fetchData(current_page);
    }




        return (<>
        <div className="z-[1500]">
        <input type="checkbox" id="create" className="peer fixed appearance-none opacity-0" />
        <label htmlFor="create" className="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100 z-[5000]">
        <label className="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-[80%] overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition z-[6000]" htmlFor="">
            <form className="w-[600px] m-auto px-4 py-4" action="" method="" onSubmit={(e)=>handleCreate(e)}>
                <div className="flex items-center mb-6">
                    <div className="w-1/5">
                        <label className="block text-gray-500 font-bold text-left" htmlFor="todo name">
                        To do name:
                        </label>
                    </div>
                    <div className="w-4/5">
                        <input className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="todo_name" type="text" name="name" placeholder="" onChange={(e)=>setCreateData({...createData, name:e.target.value})}/>
                    </div>
                </div>
    
                <div className="flex items-center mb-6">
                    <div className="w-1/5">
                        <label className="block text-gray-500 font-bold text-left" htmlFor="description">
                        Description:
                        </label>
                    </div>
                    <div className="w-4/5">
                        <input className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="description" type="text" name="description" placeholder="" onChange={(e)=>setCreateData({...createData, description: e.target.value})}/>
                    </div>
                </div>
    
    
                <div className="flex items-center mb-6">
                    <div className="w-1/5">
                      <label className="block text-gray-500 font-bold text-left " htmlFor="project_id">
                        Project name:
                      </label>
                    </div>
                    <div className="w-4/5">
                        <select name="project_id" id="project_id" onChange={(e)=>setCreateData({...createData, project_id:e.target.value})}>
                            {/* <ProjectsSelect data={pu['projects']}/> */}
                        </select>
                    </div>
                  </div>
    
                  <div className="flex items-center mb-6">
                    <div className="w-1/5">
                      <label className="block text-gray-500 font-bold text-left " htmlFor="user_id">
                        Belongs to:
                      </label>
                    </div>
                    <div className="w-4/5">
                        <select name="user_id" id="user_id" onChange={(e)=>setCreateData({...createData, user_id:e.target.value})}>
                            {/* <UsersSelect data={pu['users']}/> */}
                        </select>
                    </div>
                  </div>
    
    
                <div className="flex items-center mb-6">
                    <div className="w-1/5">
                      <label className="block text-gray-500 font-bold text-left" htmlFor="description">
                        Deadline:
                      </label>
                    </div>
                    <div className="w-4/5">
                      <input className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="deadline" type="datetime-local" name="deadline" placeholder="" onChange={(e)=>setCreateData({...createData, deadline: e.target.value})}/>
                    </div>
                  </div>
    
                <div className="flex items-center">
                  <div className="w-full">
                    <button className="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded w-full" type="submit">
                      Submit
                    </button>
                  </div>
                </div>
              </form>
        </label>
        </label>
    </div>
        
    </>);
}



function ProjectsSelect({data}){
    return (
        <>
          {data.map((project, index) => {
            if(index == 0){
                return (
                    <option key={index} defaultValue={project.id}>{project.name}</option>);
            }
            else{
                return (
                    <option key={index} defaultValue={project.id}>{project.name}</option>);
            }
            
          })
          }
        </>
    );
}

function UsersSelect({data}){
    return(<>
    {
        data.map((user,index)=>{
            return (
                <option key={index} defaultValue={user.id}>
                    {user.name}
                </option>);
        })
    }
    </>);
}


export default Create;