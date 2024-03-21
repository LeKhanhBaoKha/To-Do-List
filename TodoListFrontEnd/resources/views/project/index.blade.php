@extends('layouts.app')
@section('content')
@php
    $userinfo = $user;
@endphp
<div class="w-full overflow-auto">
    <table class="table-auto lg:w-[500px] md:w-[400px] m-auto">
        <thead>
          <tr class="bg-gradient-to-br from-pink-50 to-indigo-100">
            <th class="px-4 py-2 rounded-l-lg lg:table-cell">Project name</th>
            <th class="px-4 py-2 rounded-r-lg">function</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($projects as $project)
        {{-- table row --}}
        <tr class="hover:bg-green-50 transition duration-300 ease-in-out rounded-xl">
          {{-- project name --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 text-justify hidden lg:table-cell ">{{$project['name']}}</td>

          {{-- function --}}
          <td class="box-border border-b-2 border-gray-150 px-4 py-2 rounded-r-lg">
            <div class="flex justify-center">

                <button class="{{$project['id']}}-delmodal font-bold py-1 px-2 rounded bg-red-500 hover:bg-red-50 hover:text-red-500 text-white transition duration-[0.5s] ease-in-out" id="del-button" onclick="getDelClass(this.classList[0])">
                    <label for="{{$project['id']}}-delmodal" class="cursor-pointer rounded"><x-fas-trash-can class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] "/></label>
                </button>

            </div>
          </td>
          {{-- end of functions --}}
        </tr>
        @endforeach

        </tbody>
    </table>
        {{-- end table row --}}

        <div class="lg:w-[500px] md:w-[400px] m-auto z-0 mb-4">
            @include('TestPagination')
        </div>
</div>


<script>
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

</script>
@endsection
