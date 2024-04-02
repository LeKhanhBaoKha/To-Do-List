import { Outlet, useLocation, useNavigate } from "react-router-dom";
import React, { useEffect, useRef } from "react";
import { useState } from "react";
const Layout = () => {
  const navigate = useNavigate();

  // Handling footer
  const footerRef = useRef(null);
  var footerClass = "bg-gray-800 shadow";
  const currentUrl = window.location.href;
  const location = useLocation();

  // getting token then check of the user is login
  var token = sessionStorage.getItem("token");
  var user = sessionStorage.getItem("user");

  if (
    currentUrl.includes("login") ||
    currentUrl.includes("register") ||
    currentUrl.includes("")
  ) {
    footerClass = "bg-gray-800 shadow footer";
  }

  function handleLogout() {
    fetch("http://localhost:8008/api/logout", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          sessionStorage.clear();
          token = null;
          user = null;
          navigate("/login");
        } else {
          console.log("fail to logout");
        }
      })
      .catch(() => {
        console.log("fail to fetch logout");
      });
  }

  return (
    <>
      <div className="roboto-regular h-screen bg-gradient-to-br from-pink-50 to-indigo-100 overflow-auto">
        <nav className="bg-gray-800 mb-5">
          <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div className="relative flex h-10 items-center justify-between">
              <div className="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div className="flex flex-shrink-0 items-center">
                  <img
                    className="h-8 w-auto"
                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                    alt="BaoKha-TodoList"
                  />
                </div>
                <div className="sm:ml-6 sm:block items-center">
                  <div className="flex space-x-4 ">
                    <p className=" text-gray-300 rounded-md px-3 py-2 text-sm font-medium">
                      Hello, Have you checked your to-do list?
                    </p>
                    <a
                      href="register"
                      className=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out text-gray-100"
                    >
                      Register
                    </a>

                    {user != null ? (
                      <a
                        href="#"
                        className=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out  text-gray-100"
                        onClick={handleLogout}
                      >
                        Logout
                      </a>
                    ) : (
                      <a
                        href="login"
                        className=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out  text-gray-100"
                      >
                        Login
                      </a>
                    )}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>

        <Outlet />

        <footer className={footerClass} id="footer">
          <div className="w-full mx-auto max-w-screen-xl p-2` md:flex md:items-center md:justify-between">
            <p className="text-gray-300 rounded-md px-3 py-2 text-sm font-medium">
              @copy right: lekhanhbaokha@gmail.com
            </p>
          </div>
        </footer>
      </div>
    </>
  );
};
export default Layout;
