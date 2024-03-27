import axios from 'axios';
import { useEffect, useState } from 'react';
import { useNavigate } from "react-router-dom";
import Alert from '@mui/material/Alert';


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
        axios.post('http://localhost:8008/api/login', data).then((response) =>{
            // console.log("data:",response.data);
            // console.log("token:",response.data.authorisation.token);
            // console.log("response:", response.data.status);
            if(response.data.status == 'success'){
                //Store user token in the session storage
                sessionStorage.setItem('token', response.data.authorisation.token);
                sessionStorage.setItem('user', response.data.user);
                navigate('/index');
            }
        }).catch((error) =>{
            AlertError()
        })
    }
    return(
        <div class="mx-auto rounded-2xl border bg-white p-2 shadow-sm w-[600px] mt-[100px]">
            <div class="flex justify-center items-center content-center h-[340px] px-4">
                    <form class="sm:w-[500px] md:w-[600px] px-8 pt-6 pb-8 h-[280px]" method="" action="" onSubmit={handleLogin}>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email" name="email" value={email} required onChange={(e)=>setEmail(e.target.value)}/>
                        <span class="error-message hidden">This field is required.</span>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password" value={password} onChange={(e)=>setPassword(e.target.value)} required/>
                    </div>
                    <div class="flex items-center justify-between">

                    {
                        email == '' || password == '' ?
                        (
                            <button class="bg-purple-400 focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" disabled type="submit">
                            Sign In
                            </button>
                        )
                        :
                        (
                            <button class="bg-purple-500 hover:bg-purple-400 hover:cursor-pointer focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition" type="submit">
                            Sign In
                            </button>
                        )
                    }

                        <a class="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800" href="#">
                        Forgot Password?
                        </a>
                    </div>
                    <div className='hidden' id='Alert'>
                        <Alert severity="error" className='mt-2'>Incorrect email or password! Please try again.</Alert>
                    </div>
                    </form>
                </div>
        </div>
    
    );
}

function AlertError(){
    console.log("AlertError");
    const AlertDiv = document.getElementById('Alert');
    AlertDiv.classList.remove('hidden');
}


export default Login;