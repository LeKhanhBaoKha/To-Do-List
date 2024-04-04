import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGear } from "@fortawesome/free-solid-svg-icons";
import { useState } from "react";
import "./Edit.css";
import React from "react";
function Edit({ todo, data, fetchData }) {
  const [selectedState, setSelectedState] = useState(todo["state"]);
  const [editData, setEditData] = useState(todo);

  const token = sessionStorage.getItem("token");
  const current_page = sessionStorage.getItem("current_page");

  const handleNameChange = (e) => {
    setEditData({ ...editData, name: e.target.value });
  };

  function handleEditSubmit(event) {
    event.preventDefault();
    const dataToSend = {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify(editData),
    };
    fetch("http://localhost:8008/api/serve/update", dataToSend)
      .then((response) => response.json())
      .catch((error) => console.error(error));
    fetchData(current_page);
  }

  const { projects, users } = data;
  return (
    <>
      <button className="font-bold py-1 px-2 rounded bg-purple-500  text-white mr-2 editButton">
        <label
          htmlFor={[todo["id"], "-editmodal"].join("")}
          className="cursor-pointer rounded"
        >
          <FontAwesomeIcon
            icon={faGear}
            className="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] gear"
          />
        </label>
      </button>
      <div className="z-10">
        <input
          type="checkbox"
          id={[todo["id"], "-editmodal"].join("")}
          className="peer fixed appearance-none opacity-0"
        />
        <label
          htmlFor={[todo["id"], "-editmodal"].join("")}
          className="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100"
        >
          <label
            className="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-[80%] overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition"
            htmlFor=""
          >
            <form
              className="w-[600px] m-auto px-4 py-4"
              action=""
              method=""
              onSubmit={handleEditSubmit}
            >
              <input
                type="hidden"
                name="id"
                defaultValue={todo["id"]}
                style={{ display: "none" }}
              />

              <div className="flex items-center mb-6">
                <div className="w-1/5">
                  <label
                    className="block text-gray-500 font-bold text-left"
                    htmlFor="todo name"
                  >
                    To do name:
                  </label>
                </div>
                <div className="w-4/5">
                  <input
                    className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                    id="todo name"
                    type="text"
                    defaultValue={editData["name"]}
                    onChange={(e) =>
                      setEditData({
                        ...editData,
                        name: e.target.value,
                      })
                    }
                    name="name"
                  />
                </div>
              </div>

              <div className="flex items-center mb-6">
                <div className="w-1/5">
                  <label
                    className="block text-gray-500 font-bold text-left"
                    htmlFor="description"
                  >
                    Description:
                  </label>
                </div>
                <div className="w-4/5">
                  <input
                    className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                    id="description"
                    type="text"
                    name="description"
                    defaultValue={editData["description"]}
                    onChange={(e) =>
                      setEditData((prev) => ({
                        ...prev,
                        description: e.target.value,
                      }))
                    }
                  />
                </div>
              </div>

              <div className="flex items-center mb-6">
                <div className="w-1/5">
                  <label
                    className="block text-gray-500 font-bold text-left "
                    htmlFor="project_id"
                  >
                    Project name:
                  </label>
                </div>
                <div className="w-4/5">
                  <select
                    name="project_id"
                    id="project_id"
                    onChange={(e) =>
                      setEditData((prev) => ({
                        ...prev,
                        project_id: e.target.value,
                      }))
                    }
                  >
                    <option value={editData["project"]["id"]}>
                      {editData["project"]["name"]}
                    </option>
                    <ProjectsSelect
                      data={projects}
                      todoProjectName={editData["project"]["name"]}
                    />
                  </select>
                </div>
              </div>

              <div className="flex items-center mb-6">
                <div className="w-1/5">
                  <label
                    className="block text-gray-500 font-bold text-left "
                    htmlFor="user_id"
                  >
                    Belongs to:
                  </label>
                </div>
                <div className="w-4/5">
                  <select
                    name="user_id"
                    id="user_id"
                    onChange={(e) =>
                      setEditData((prev) => ({
                        ...prev,
                        user_id: e.target.value,
                      }))
                    }
                  >
                    <option value={editData["user"]["id"]} selected>
                      {editData["user"]["name"]}
                    </option>
                    <UsersSelect
                      data={users}
                      username={editData["user"]["name"]}
                    />
                  </select>
                </div>
              </div>

              <div className="flex items-center mb-6">
                <div className="w-1/5">
                  <label
                    className="block text-gray-500 font-bold text-left"
                    htmlFor="deadline"
                  >
                    Deadline:
                  </label>
                </div>
                <div className="w-4/5">
                  <input
                    className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                    id="deadline"
                    type="datetime-local"
                    name="deadline"
                    defaultValue={editData["deadline"]}
                    onChange={(e) => {
                      setEditData((prev) => ({
                        ...prev,
                        deadline: e.target.value,
                      }));
                    }}
                  />
                </div>
              </div>

              <div className="flex md:items-center h-[50px] justify-between">
                <div className="w-[10%] h-full pb-14">
                  <label
                    className="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    htmlFor="state"
                  >
                    State:
                  </label>
                </div>
                <div className="w-[80%] flex pb-3 gap-4">
                  <div className="flex items-center mb-4">
                    <input
                      type="radio"
                      name="state"
                      defaultValue="0"
                      className="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                      aria-labelledby="state-option-1"
                      aria-describedby="state-option-1"
                      id={["inprocess", editData["id"]].join("")}
                      checked={selectedState == 0}
                      onChange={(e) => {
                        setSelectedState(e.target.value);
                        setEditData((prev) => ({
                          ...prev,
                          state: e.target.value,
                        }));
                      }}
                    />
                    <label
                      htmlFor="state-option-1"
                      className="text-sm font-medium text-gray-900 ml-2 block"
                    >
                      In progress
                    </label>
                  </div>
                  <div className="flex items-center mb-4">
                    <input
                      type="radio"
                      name="state"
                      defaultValue="1"
                      className="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                      aria-labelledby="state-option-2"
                      aria-describedby="state-option-2"
                      id={["complete", editData["id"]].join("")}
                      checked={selectedState == 1}
                      onChange={(e) => {
                        setSelectedState(e.target.value);
                        setEditData((prev) => ({
                          ...prev,
                          state: e.target.value,
                        }));
                      }}
                    />
                    <label
                      htmlFor="state-option-2"
                      className="text-sm font-medium text-gray-900 ml-2 block"
                    >
                      Complete
                    </label>
                  </div>
                </div>
              </div>

              <div className="flex items-center">
                <div className="w-full">
                  <button
                    className="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded w-full"
                    type="submit"
                  >
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </label>
        </label>
      </div>
    </>
  );
}
export default Edit;

function ProjectsSelect({ data, todoProjectName }) {
  return (
    <>
      {data.map((project, index) => {
        if (project.Name === todoProjectName) {
          return null;
        } else {
          return (
            <option key={index} value={project.id}>
              {project.name}
            </option>
          );
        }
      })}
    </>
  );
}

function UsersSelect({ data, username }) {
  return (
    <>
      {data.map((user, index) => {
        if (username == user["Name"]) {
          return null;
        } else {
          return (
            <option key={index} value={user.id}>
              {user.name}
            </option>
          );
        }
      })}
    </>
  );
}
