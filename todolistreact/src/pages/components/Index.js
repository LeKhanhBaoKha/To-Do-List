import { useEffect, useState } from "react";
import * as React from "react";
import CircularProgress from "@mui/material/CircularProgress";
import Box from "@mui/material/Box";
import Check from "./function/check";
import Details from "./function/details";
import Edit from "./function/Edit";
import Delete from "./function/Delete";
import Paging from "./Pagination";
import Create from "./function/Create";
import RenderTimeLeft from "./function/renderTimeLeft";
import "./Index.css";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
const Index = () => {
  const [todos, setTodos] = useState(null);
  const [error, setError] = useState(null);
  const [isLoading, setIsLoading] = useState(false);
  const [data, setData] = useState(null);
  const [links, setLinks] = useState(null);
  const token = sessionStorage.getItem("token");
  const user = JSON.parse(sessionStorage.getItem("user"));
  const detailsInput = React.useRef(null);

  const fetchData = async (url) => {
    setIsLoading(true);
    setError(null);
    try {
      const todoResponse = await fetch(url, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      if (!todoResponse.ok) {
        throw new Error(
          `Api request failed with status ${todoResponse.status}`
        );
      }
      const todoData = await todoResponse.json();
      console.log("responseData", todoData);
      setTodos(todoData.data);
      setLinks(todoData);

      const createResponse = await fetch(
        "http://localhost:8008/api/serve/createData",
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );
      if (!createResponse.ok) {
        throw new Error(
          `Api request htmlFor projects failed with status ${createResponse.status}`
        );
      }
      const CreateData = await createResponse.json();
      setData(CreateData);
    } catch (error) {
      setError(error.message);
      console.log(todos);
    } finally {
      setIsLoading(false);
    }
  };

  function selectState(event) {
    var url = event.target.value;
    fetchData(url);
  }

  const fetchInitialData = async () => {
    sessionStorage.setItem(
      "current_page",
      "http://localhost:8008/api/serve/index"
    );
    await fetchData("http://localhost:8008/api/serve/index");
  };

  useEffect(() => {
    fetchInitialData();
  }, []);
  if (error) {
    return (
      <div className="container mx-auto flex items-center justify-center h-[80vh]">
        <p className="font-bold py-2 px-4 rounded text-gray-600 text-lg	">
          Error: {error}
        </p>
      </div>
    );
  }

  if (isLoading == true) {
    return (
      <div className="container mx-auto flex items-center justify-center h-[80vh]">
        <div className="loader">
          <div className="circles">
            <span className="one"></span>
            <span className="two"></span>
            <span className="three"></span>
          </div>
          <div className="pacman">
            <span className="top"></span>
            <span className="bottom"></span>
            <span className="left"></span>
            <div className="eye"></div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="index">
      <div
        className="mx-auto rounded-2xl border bg-white p-2 w-[85%] mb-4"
        id="index"
      >
        <div className="2xl:w-[1500px] lg:w-[1000px] m-auto">
          <div className="max-w-sm my-4 inline-block">
            <label
              htmlFor="index_select"
              className="mb-2 block text-sm font-medium text-gray-900"
            >
              Select an option
            </label>
            <select
              id="index_select"
              className="block w-full rounded-lg border border-gray-400 bg-gray-50 p-2.5 text-sm text-gray-600 focus:border-purple-400 focus:ring-purple-400"
              onChange={(e) => selectState(e)}
            >
              <option>Choose a state</option>
              <option value="http://localhost:8008/api/serve/index">All</option>
              <option value="http://localhost:8008/api/serve/completed">
                Completed
              </option>
              <option value="http://localhost:8008/api/serve/inprocess">
                In process
              </option>
            </select>
          </div>

          <div className="inline-block ml-2">
            <a
              href="#"
              className=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out border-gray-300 border hover:border-none "
              onClick={(e) =>
                fetchData("http://localhost:8008/api/serve/todaytask")
              }
            >
              Today&apos;s task
            </a>
          </div>

          {data != null && (
            <div className="inline-block ml-2">
              <a className="hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out border-gray-300 border hover:border-none ">
                <label htmlFor="create" className="cursor-pointer rounded">
                  <FontAwesomeIcon icon={faPlus} />
                  &nbsp;Create
                </label>
              </a>
              <Create data={data} fetchData={fetchData} />
            </div>
          )}
        </div>
        {todos != null && data != null ? (
          <div className="w-full overflow-auto">
            <table className="table-auto 2xl:w-[1500px] lg:w-[1000px] m-auto mb-5">
              <thead>
                <tr className="bg-gradient-to-br from-pink-50 to-indigo-100">
                  <th className="px-4 py-2 rounded-l-lg">Todo name</th>
                  <th className="px-4 py-2 sm:hidden md:table-cell">
                    Project name
                  </th>
                  <th className="px-4 py-2">state </th>
                  <th
                    className={`px-4 py-2 sm:hidden md:table-cell ${
                      user["is_admin"] == 0 && "md:hidden"
                    }`}
                  >
                    Belongs to
                  </th>
                  <th className="px-4 py-2">Time left</th>

                  <th className="px-4 py-2 rounded-r-lg">function</th>
                </tr>
              </thead>
              <tbody>
                {todos.map((todo, index) => (
                  <tr
                    key={todo["id"]}
                    className="hover:bg-green-50 transition duration-300 ease-in-out rounded-xl cursor-pointer"
                  >
                    {/* name */}
                    <td
                      className="box-border border-b-2 border-gray-150  px-4 py-2 text-left rounded-l-lg"
                      onClick={() => {
                        detailsInput.current.checked = true;
                      }}
                    >
                      {todo["name"]}
                    </td>

                    {/* projectname */}
                    <td
                      className="box-border border-b-2 border-gray-150  px-4 py-2 text-left rounded-l-lg sm:hidden md:table-cell"
                      onClick={() => {
                        detailsInput.current.checked = true;
                      }}
                    >
                      {todo["project"]["name"]}
                    </td>

                    {/* state */}
                    {todo["state"] == 1 ? (
                      <td
                        className="box-border border-b-2 border-gray-150 px-4 py-2 text-center w-[120px]"
                        onClick={() => {
                          detailsInput.current.checked = true;
                        }}
                      >
                        <p className="font-bold text-green-600 bg-green-50 rounded-lg">
                          Complete
                        </p>
                      </td>
                    ) : (
                      <td
                        className="box-border border-b-2 border-gray-150 px-4 py-2 text-center w-[120px]"
                        onClick={() => {
                          detailsInput.current.checked = true;
                        }}
                      >
                        <p className="font-bold text-blue-600 bg-blue-50 rounded-lg">
                          In process
                        </p>
                      </td>
                    )}

                    {/* belongsto */}
                    <td
                      className={`box-border border-b-2 border-gray-150 px-4 py-2 text-justify sm:hidden md:table-cell ${
                        user["is_admin"] == 0 && "md:hidden"
                      }`}
                      onClick={() => {
                        detailsInput.current.checked = true;
                      }}
                    >
                      {todo["user"]["name"]}
                    </td>

                    {/* timeLeft */}
                    <td
                      className="box-border border-b-2 border-gray-150 px-4 py-2 text-left"
                      onClick={() => {
                        detailsInput.current.checked = true;
                      }}
                    >
                      {RenderTimeLeft(todo)}
                    </td>

                    {/* function */}
                    <td className="box-border border-b-2 border-gray-150 px-4 py-2 rounded-r-lg">
                      <div className="flex justify-center">
                        {/* check button */}
                        <Check todo={todo} fetchData={fetchData} />
                        {/* end check button */}

                        {/* details */}
                        <Details todo={todo} detailsInput={detailsInput} />

                        {/* edit */}
                        <Edit todo={todo} data={data} fetchData={fetchData} />

                        {/* delete */}
                        <Delete todo={todo} fetchData={fetchData} />
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>

            {/* Pagination */}
            <div className="2xl:w-[1500px] lg:w-[1000px] m-auto z-[1000] mb-4">
              <Paging links={links} fetchData={fetchData} />
            </div>
          </div>
        ) : (
          <div className="container mx-auto flex items-center justify-center h-[80vh]">
            <p className="font-bold py-2 px-4 rounded text-gray-600 text-lg	">
              Nothing to do, let&apos;s chill
            </p>
          </div>
        )}
      </div>
    </div>
  );
};
export default Index;
