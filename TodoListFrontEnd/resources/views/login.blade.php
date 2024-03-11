@extends('layouts.app')
@section('content')
<div class="flex justify-center	content-center h-[400px]">
    <form class="sm:w-[500px] md:w-[600px] bg-white border-gray-500 border rounded px-8 pt-6 pb-8 mb-4 m-auto" method="post" action="login">
        @csrf
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email" name="email" required>
        <span class="error-message hidden">This field is required.</span>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password" required>
        {{-- <p class="text-red-500 text-xs italic">Please choose a password.</p> --}}
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-purple-500 hover:bg-purple-400 focus:shadow-outline text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Sign In
        </button>
        <a class="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800" href="#">
          Forgot Password?
        </a>
      </div>
    </form>
</div>
@endsection
