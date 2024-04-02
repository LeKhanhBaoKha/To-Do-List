import axios from "axios";
import { useEffect, useRef, useState } from "react";
import { resolvePath, useNavigate } from "react-router-dom";
import Alert from "@mui/material/Alert";
import React from "react";

const Login = () => {
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [data, setData] = useState("");
  const alert = useRef(null);
  const form = useRef(null);

  useEffect(() => {
    const info = { email: email, password: password };
    setData(info);
  }, [email, password]);

  function AlertError() {
    console.log("AlertError");
    if (alert.current) {
      alert.current.classList.remove("hidden");
      form.current.classList.add("h-[300px]");
    }
  }

  const handleLogin = (event) => {
    event.preventDefault();

    fetch("http://localhost:8008/api/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          sessionStorage.setItem("token", data.authorisation.token);
          sessionStorage.setItem("user", data.user);
          navigate("/index");
        } else {
          AlertError();
        }
      })
      .catch(() => {
        AlertError();
      });
  };

  return (
    <div className="flex justify-center items-center h-[80vh]">
      <div className="mx-auto rounded-2xl border bg-white p-2 shadow-sm w-[600px]">
        <form
          className="sm:w-[500px] md:w-[600px] px-8 pt-6 pb-8"
          method=""
          action=""
          onSubmit={handleLogin}
          ref={form}
        >
          <div className="mb-4">
            <label
              className="block text-gray-700 text-sm font-bold mb-2"
              htmlFor="email"
            >
              Email
            </label>
            <input
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              id="email"
              type="text"
              placeholder="email"
              name="email"
              defaultValue={email}
              required
              onChange={(e) => setEmail(e.target.value)}
            />
            <span className="error-message hidden">
              This field is required.
            </span>
          </div>

          <div className="mb-2">
            <label
              className="block text-gray-700 text-sm font-bold mb-2"
              htmlFor="password"
            >
              Password
            </label>
            <input
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              type="password"
              placeholder="******************"
              name="password"
              defaultValue={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>

          <div className="flex items-center justify-between mb-2">
            {email == "" || password == "" ? (
              <button
                className="bg-purple-400 focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                disabled
                type="submit"
              >
                Sign In
              </button>
            ) : (
              <button
                className="bg-purple-500 hover:bg-purple-400 hover:cursor-pointer focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition"
                type="submit"
              >
                Sign In
              </button>
            )}

            <a
              className="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800"
              href="#"
            >
              Forgot Password?
            </a>
          </div>
          <div className="hidden" id="Alert" ref={alert}>
            <Alert severity="error" className="mb-0">
              Incorrect email or password! Please try again.
            </Alert>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Login;
