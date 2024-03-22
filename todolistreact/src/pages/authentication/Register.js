import axios from "axios";
import { useEffect, useState } from "react";

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
        console.log('register data:', data);
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
        <div class="mx-auto rounded-2xl border bg-white p-2 shadow-sm w-[600px] mt-[100px]">
            <form class="sm:w-[300px] md:w-[500px] bg-white px-8 pt-6 pb-8 mb-4 m-auto" method="" action="" onSubmit={handleRegister}>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="name" name="name" value={name} onChange={(e)=>setName(e.target.value)} required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email" name="email" value={email} onChange={(e)=>setEmail(e.target.value)} required/>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************" name="password" id="password" value={password} onChange={(e)=>setPassword(e.target.value)} required/>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Re-enter password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************" name="repassword"  id="repassword" value={repassword} onChange={(e)=>setRepassord(e.target.value)} required/>
    
                </div>

                <div class="flex items-center justify-between">

                    {
                        name == '' || email == '' || password == '' || repassword == '' ?(
                        <button class="bg-purple-400  focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline " disabled type="submit">Sign up</button>
                        ):(
                            <button class="bg-purple-500 hover:bg-purple-400 hover:cursor-pointer focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline "  type="submit">Sign up</button>
                        )
                    }
                    


                    <a class="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800" href="login">
                    Already have an account? Sign in
                    </a>
                </div>
            </form>
        </div>
    
    );
}

export default Register;