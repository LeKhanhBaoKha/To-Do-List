import axios from 'axios';
import { useEffect, useState } from 'react';
import { useNavigate } from "react-router-dom";
import Alert from '@mui/material/Alert';
import React from "react";


const Login = ()=>{

    const navigate = useNavigate();

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [data, setData] = useState('');

    useEffect(()=>{
        const info ={ email:email, password: password };
        setData(info);
    },[email, password]);

    const handleLogin = (event) => {
        event.preventDefault();       
        axios.post("http://localhost:8008/api/login", data).then((response) =>{
            // console.log("data:",response.data);
            // console.log("token:",response.data.authorisation.token);
            // console.log("response:", response.data.status);
            if(response.data.status == 'success'){
                //Store user token in the session storage
                sessionStorage.setItem('token', response.data.authorisation.token);
                sessionStorage.setItem('user', response.data.user);
                navigate('/index');
            }
        }).catch(() =>{
            AlertError()
        })
    }
    return(
        <div className="mx-auto rounded-2xl border bg-white p-2 shadow-sm w-[600px] mt-[100px]">
            <div className="flex justify-center items-center content-center h-[340px] px-4">
                    <htmlForm className="sm:w-[500px] md:w-[600px] px-8 pt-6 pb-8 h-[280px]" method="" action="" onSubmit={handleLogin}>
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="email">
                        Email
                        </label>
                        <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email" name="email" value={email} required onChange={(e)=>setEmail(e.target.value)}/>
                        <span className="error-message hidden">This field is required.</span>
                    </div>
                    <div className="mb-6">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                        Password
                        </label>
                        <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password" value={password} onChange={(e)=>setPassword(e.target.value)} required/>
                    </div>
                    <div className="flex items-center justify-between">

                    {
                        email == '' || password == '' ?
                        (
                            <button className="bg-purple-400 focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" disabled type="submit">
                            Sign In
                            </button>
                        )
                        :
                        (
                            <button className="bg-purple-500 hover:bg-purple-400 hover:cursor-pointer focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition" type="submit">
                            Sign In
                            </button>
                        )
                    }

                        <a className="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800" href="#">
                        htmlForgot Password?
                        </a>
                    </div>
                    <div className='hidden' id='Alert'>
                        <Alert severity="error" className='mt-2'>Incorrect email or password! Please try again.</Alert>
                    </div>
                    </htmlForm>
                </div>
        </div>
    
    );
}

function AlertError(){
    console.log("AlertError");
    const AlertDiv = document.getElementById('Alert');
    AlertDiv.classNameList.remove('hidden');
}


export default Login;