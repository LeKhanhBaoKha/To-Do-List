import axios from "axios";
import { useEffect, useState } from "react";
import React from "react";
const Register = ()=>{
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [repassword, setRepassord] = useState('');
    const [data, setData] = useState('');

    useEffect(()=>{
        setData({name:name, email:email, password: password});
    }, [email, password, name]);

    const handleRegister = (e) =>{
        e.preventDefault();
        axios.post('http://localhost:8008/api/register', data).then((response)=>{
            if(response.data.status == 'success')
                console.log("data:",response.data);
            else{
                console.log('register fail');
            }
        }).catch((error) =>{
            console.log(error);
        })
    }
    return(
        <div className="mx-auto rounded-2xl border bg-white p-2 shadow-sm w-[600px] mt-[100px]">
            <htmlForm className="sm:w-[300px] md:w-[500px] bg-white px-8 pt-6 pb-8 mb-4 m-auto" method="" action="" onSubmit={handleRegister}>
                <div className="mb-4">
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="name">
                    Name
                    </label>
                    <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="name" name="name" value={name} onChange={(e)=>setName(e.target.value)} required />
                </div>
                <div className="mb-4">
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="email">
                    Email
                    </label>
                    <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email" name="email" value={email} onChange={(e)=>setEmail(e.target.value)} required/>
                </div>
                <div className="mb-6">
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                    Password
                    </label>
                    <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************" name="password" id="password" value={password} onChange={(e)=>setPassword(e.target.value)} required/>
                </div>

                <div className="mb-6">
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                        Re-enter password
                    </label>
                    <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************" name="repassword"  id="repassword" value={repassword} onChange={(e)=>setRepassord(e.target.value)} required/>
    
                </div>

                <div className="flex items-center justify-between">

                    {
                        name == '' || email == '' || password == '' || repassword == '' ?(
                        <button className="bg-purple-400  focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline " disabled type="submit">Sign up</button>
                        ):(
                            <button className="bg-purple-500 hover:bg-purple-400 hover:cursor-pointer focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline "  type="submit">Sign up</button>
                        )
                    }
                    <a className="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800" href="login">
                    Already have an account? Sign in
                    </a>
                </div>
            </htmlForm>
        </div>
    
    );
}

export default Register;