import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import { format } from "date-fns";
import React, { useEffect, useRef } from "react";
import "./Details.css";
function Details({ todo, detailsInput }) {
  function animatedDetail() {
    const detailButton = document.getElementById(
      [todo["id"], "dt-button"].join("")
    );
    detailButton.addEventListener("mouseover", () => {
      const detailIcon = document.getElementById(
        [todo["id"], "dt-icon"].join("")
      );
      detailIcon.classList.add("animated");
    });
  }

  function handleOpen() {
    detailsInput.current.checked = true;
  }

  useEffect(() => {
    console.log(detailsInput.current); // Log after DOM update
  }, []);

  return (
    <>
      <div className="z-10">
        <input
          type="checkbox"
          id={[todo["id"], "-modal"].join("")}
          className="peer fixed appearance-none opacity-0"
          ref={detailsInput}
        />
        <label
          htmlFor={[todo["id"], "-modal"].join("")}
          className="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100"
        >
          <label
            className="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-lg overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition"
            htmlFor={[todo["id"], "-modal"].join("")}
          >
            <h3 className="py-2 text-lg font-bold text-center">
              Name: {todo["name"]}
            </h3>
            <p className="py-1">Description: {todo["description"]}</p>
            <div className="flex">
              <label htmlFor="" className="py-1">
                State:&nbsp;
              </label>
              {todo["state"] == 0 ? (
                <p className="py-1 text-blue-500 font-bold">In process</p>
              ) : (
                <p className="py-1 text-green-500 font-blod">Complete</p>
              )}
            </div>
            <p className="py-1">Project: {todo["project"]["name"]}</p>
            <p className="py-1">Belongs to: {todo["user"]["name"]}</p>
            <p className="py-1">
              Starting date:{" "}
              {format(todo["created_at"], "MMMM do yyyy, h:mm:ss a")}
            </p>
            <p className="py-1">
              Deadline: {format(todo["deadline"], "MMMM do yyyy, h:mm:ss a")}
            </p>
          </label>
        </label>
      </div>
    </>
  );
}

export default Details;
