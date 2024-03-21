@extends('layouts.app')
@section('css')
@keyframes spin360 {
    from {
       transform: rotate(0deg);
    }
    to {
       transform: rotate(360deg);
    }
   }

   .editButton:hover .gear {
    animation: spin360 3s linear infinite;
   }

   @keyframes zoomInAndSpin {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(1.3);
    }
}

/* Define the animation for zoom out and spin back */
@keyframes zoomOutAndSpinBack {
    0% {
        transform: scale(1.3);
    }
    100% {
        transform: scale(1) ;
    }
}

/* Apply the zoom in and spin animation to the SVG when the button is hovered */
.details-button:hover .details {
    animation: zoomInAndSpin 0.5s ease-in-out forwards;
}

/* Apply the zoom out and spin back animation to the SVG when the button is not hovered */
.details-button:not(:hover) .details {
    animation: zoomOutAndSpinBack 0.5s ease-in-out;
}
@endsection
@section('content')

@php
    $userinfo = $user;
@endphp
@if ($todos != null)

{{-- todotable --}}
<div class="w-full overflow-auto">
    <div class="lg:w-[1500px] md:w-[800px] m-auto">
        <div class="max-w-sm my-4 inline-block">
            <label for="index_select" class="mb-2 block text-sm font-medium text-gray-900">Select an option</label>
            <select id="index_select" class="block w-full rounded-lg border border-gray-400 bg-gray-50 p-2.5 text-sm text-gray-600 focus:border-purple-400 focus:ring-purple-400" onchange="navigateTo()">
              <option selected>Choose state</option>
              <option value="http://127.0.0.1:8000/api/index">All</option>
              <option value="http://127.0.0.1:8000/api/completed">Completed</option>
              <option value="http://127.0.0.1:8000/api/inprocess">In process</option>
            </select>
        </div>

        <div class="inline-block ml-2">
            <a href="todaytask" class=" hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition duration-300 ease-in-out border-gray-300 border hover:border-none ">Today's task</a>
        </div>
    </div>


    <table class="table-auto lg:w-[1500px] md:w-[800px] m-auto mb-5">
        <thead>
          <tr class="bg-gradient-to-br from-pink-50 to-indigo-100">
            <th class="px-4 py-2 rounded-l-lg" >Todo name of {{$user['is_admin'] ==1 ? 'Everyone' : $user['name']}}</th>
            <th class="px-4 py-2 hidden lg:table-cell">Project name</th>
            <th class="px-4 py-2">state </th>

            <th class="px-4 py-2 {{$userinfo['is_admin'] == 1 ? '':'hidden'}}">Belongs to</th>

            <th class="px-4 py-2">Time left</th>

            {{-- @if(auth()->check()) --}}
            <th class="px-4 py-2 rounded-r-lg">function</th>
            {{-- @endif --}}

        </tr>
        </thead>
        <tbody>

        @foreach ($todos as $todo)
        {{-- table row --}}
        <tr class="hover:bg-green-50 transition duration-300 ease-in-out rounded-xl
            @if ($todo['timeleft']['days'] == 0 && $todo['timeleft']['hours'] == 0 && $todo['timeleft']['minutes'] != 0)
                @if ($todo['timeleft']['minutes'] > 10)
                    bg-orange-300
                @else
                    bg-red-400
                @endif
            @endif
        ">
            {{-- name --}}
          <td class="box-border border-b-2 border-gray-150  px-4 py-2 text-justify rounded-l-lg">{{$todo["name"]}}</td>
          {{-- project name --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-justify hidden lg:table-cell ">{{$todo['project']['name']}}</td>
          {{-- state name --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-center	">
          @if($todo['state'] == 0)
              <p class="font-bold text-blue-600 bg-blue-50 rounded-lg">In process</p>
          @else
              <p class="font-bold text-green-600 bg-green-50 rounded-lg">Complete</p>
          @endif
          </td>
          {{-- belongs to --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 {{$userinfo['is_admin'] == 1 ? '':'hidden'}} text-justify">
              {{$todo['user']['name']}}
          </td>

          {{-- timeleft --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-left">
            @if ($todo['timeleft']['days'] == 0 && $todo['timeleft']['hours'] == 0 && $todo['timeleft']['minutes'] == 0)
                <p class="font-bold text-red-600 bg-red-50 rounded-lg text-center w-[80px] m-auto">Time's up</p>
            @else
                @if ($todo['timeleft']['days'] != 0)
                {{$todo['timeleft']['days']}} days
                @endif
                @if ($todo['timeleft']['hours'] != 0)
                    {{$todo['timeleft']['hours']}} hours
                @endif
                @if ($todo['timeleft']['minutes'] != 0 )
                    {{$todo['timeleft']['minutes']}} minutes
                @endif
            @endif
            </td>

          {{-- function --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 rounded-r-lg">
            <div class="flex justify-center">

                {{-- check button --}}
                @include('check')
                {{-- end check button --}}


                    {{-- details button --}}
                  <button class="{{$todo['id']}}-modal font-bold py-1 px-2 rounded bg-purple-500  text-white mr-2 details-button" id="dt-button" >
                      <label for="{{$todo['id']}}-modal" class="cursor-pointer rounded"><x-fas-pen-to-square class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] details"/></label>
                  </button>
                    {{-- end details button --}}

                {{-- details modal form --}}
                  @include('details')

                    {{-- edit button --}}
                  <button class="font-bold py-1 px-2 rounded bg-purple-500  text-white mr-2 editButton">
                      <label for="{{$todo['id']}}-editmodal" class="cursor-pointer rounded"><x-fas-gear class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] gear"/></label>
                  </button>
                   {{-- edit modal form --}}
                   @include('edit')


                    {{-- delete button --}}
                    <button class="{{$todo['id']}}-delmodal font-bold py-1 px-2 rounded bg-red-500 hover:bg-red-50 hover:text-red-500 text-white transition duration-[0.5s] ease-in-out" id="del-button" onclick="getDelClass(this.classList[0])">
                        <label for="{{$todo['id']}}-delmodal" class="cursor-pointer rounded"><x-fas-trash-can class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] "/></label>
                    </button>
                    {{-- end delete button --}}

                    {{-- del modal form --}}
                    @include('delete')
            </div>
          </td>
          {{-- end of functions --}}
        </tr>
        {{-- end table row --}}
        @endforeach


        @else

        <div class="container mx-auto flex items-center justify-center h-[80vh]">
            <p class="font-bold py-2 px-4 rounded text-gray-600 text-lg	">Nothing to do, let's chill</p>
        </div>

        @endif

        </tbody>
      </table>
      {{-- end of todo table --}}
</div>


  <div class="lg:w-[1500px] md:w-[800px] m-auto z-0 mb-4">
    @include('TestPagination')
  </div>


  <x-notify::notify />
  @notifyJs
    <script>

    //this javascript is to close the delete button
    var delModal
    function getDelClass(classList){
        delModal = classList;
        console.log('delModal: ', delModal);
    }
    document.addEventListener('DOMContentLoaded', function () {
       const closeButtons = document.querySelectorAll('.close-modal');
       closeButtons.forEach(function (button) {
         button.addEventListener('click', function () {
           document.getElementById(delModal).checked = false;
         });
       });
    });

    //this is use for the select tag
    function navigateTo(){
        var select = document.getElementById('index_select');
        var selectedOption = select.options[select.selectedIndex].value;
        if(selectedOption){
            window.location.href = selectedOption;
        }
    }
   </script>
@endsection
