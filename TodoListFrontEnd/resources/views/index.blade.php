@extends('layouts.app')
@section('content')
<table class="table-auto md:w-[1200px] m-auto">
    <thead>
      <tr>
        <th class="px-4 py-2">Todo name</th>
        <th class="px-4 py-2">Project name</th>
        <th class="px-4 py-2">state</th>
        <th class="px-4 py-2">Belongs to</th>

        {{-- @if(auth()->check()) --}}
        <th class="px-4 py-2">function</th>
        {{-- @endif --}}

    </tr>
    </thead>
    <tbody>
    @if ($todos != null)
    @foreach ($todos as $todo)
    <tr>
      <td class="border px-4 py-2">{{$todo["name"]}}</td>
      <td class="border px-4 py-2">{{$todo['project']['name']}}</td>
      <td class="border px-4 py-2">
      @if($todo['state'] == 0)
          <p class="font-bold text-blue-600">In process</p>
      @else
          <p class="font-bold text-green-600">Complete</p>
      @endif
      </td>

      <td class="border px-4 py-2">
          {{$todo['user']['name']}}
      </td>

      {{-- @if (auth()->check()) --}}
      <td class="border px-4 py-2 flex justify-center">
          <button class="{{$todo['id']}}-modal font-bold py-2 px-4 rounded bg-blue-500 hover:bg-blue-400 text-white mr-2 " id="dt-button" onclick="replyClick(this.classList[0])">
              <label for="{{$todo['id']}}-modal" class="cursor-pointer rounded">Details</label>
          </button>

        {{-- details modal form --}}
        <div class="">
            <input type="checkbox" id="{{$todo['id']}}-modal" class="peer fixed appearance-none opacity-0" />
            <label for="{{$todo['id']}}-modal" class="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
            <label class="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-lg overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" for="">
                <h3 class="py-2 text-lg font-bold text-center">Name: {{$todo["name"]}}</h3>
                <p class="py-1">Description: {{$todo['description']}}</p>
                <div class="flex">
                    <label for="" class="py-1">State:&nbsp;</label>
                    @if($todo['state'] == 0)
                        <p class="py-1 text-blue-500 font-bold">In process</p>
                    @else
                        <p class="py-1 text-green-500 font-blod">Complete</p>
                    @endif
                </div>
                <p class="py-1">Project: {{$todo['project']['name']}}</p>
                <p class="py-1">Belongs to: {{$todo['user']['name']}}</p>

            </label>
            </label>
        </div>

          <button class="font-bold py-2 px-4 rounded bg-blue-500 hover:bg-blue-400 text-white mr-2">
              <label for="{{$todo['id']}}-editmodal" class="cursor-pointer rounded">Edit</label>
          </button>

           {{-- edit modal form --}}
            <div class="">
                <input type="checkbox" id="{{$todo['id']}}-editmodal" class="peer fixed appearance-none opacity-0" />
                <label for="{{$todo['id']}}-editmodal" class="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
                <label class="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-[80%] overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" for="">
                    <form class="w-[600px] m-auto px-4 py-4" action="update" method="post">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="id" value={{$todo['id']}} style="display:none">

                        <div class="flex items-center mb-6">
                          <div class="w-1/5">
                            <label class="block text-gray-500 font-bold text-left" for="todo name">
                              To do name:
                            </label>
                          </div>
                          <div class="w-4/5">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="todo name" type="text" value="{{$todo['name']}}" name="name">
                          </div>
                        </div>

                        <div class="flex items-center mb-6">
                          <div class="w-1/5">
                            <label class="block text-gray-500 font-bold text-left" for="description">
                              Description:
                            </label>
                          </div>
                          <div class="w-4/5">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="description" type="text" name="description" value="{{$todo['description']}}">
                          </div>
                        </div>

                        <div class="flex items-center mb-6">
                            <div class="w-1/5">
                              <label class="block text-gray-500 font-bold text-left " for="project_id">
                                Project name:
                              </label>
                            </div>
                            <div class="w-4/5">
                                <select name="project_id" id="project_id">
                                    <option value="{{$todo['project']['id']}}">{{$todo['project']['name']}}</option>
                                    @foreach ($data['projects'] as $project)
                                        @if ($todo['project']['name'] == $project['name'])
                                            @continue
                                        @else
                                            <option value="{{$project['id']}}">{{$project['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                          </div>

                          <div class="flex items-center mb-6"
                          {{-- @if (auth()->user()->is_admin != 1) --}}
                          {{-- style="display:none;" --}}
                          {{-- @endif --}}
                          >
                            <div class="w-1/5">
                              <label class="block text-gray-500 font-bold text-left " for="user_id">
                                Belongs to:
                              </label>
                            </div>
                            <div class="w-4/5">
                                <select name="user_id" id="user_id">
                                    <option value="{{$todo['user']['id']}}">{{$todo['user']['name']}}</option>
                                    @foreach ($data['users'] as $user)
                                        @if ($todo['user']['name'] == $user['name'])
                                            @continue
                                        @else
                                        <option value="{{$user['id']}}">{{$user['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                          </div>

                        <div class="flex md:items-center h-[50px] justify-between">
                            <div class="w-[10%] h-full pb-14">
                                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="state">
                                    State:
                                  </label>
                            </div>
                            <div class="w-[80%] flex pb-3 gap-4">
                                <div class="flex items-center mb-4">
                                    <input type="radio" name="state" value="0" class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="state-option-1" aria-describedby="state-option-1"  @if ($todo['state'] == 0)
                                    checked
                                    @endif
                                    >
                                    <label for="state-option-1" class="text-sm font-medium text-gray-900 ml-2 block" >
                                    In progress
                                    </label>
                                </div>
                                <div class="flex items-center mb-4">
                                    <input id="state-option-2" type="radio" name="state" value="1" class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="state-option-2" aria-describedby="state-option-2" @if ($todo['state'] == 1)
                                    checked
                                    @endif>
                                    <label for="state-option-2" class="text-sm font-medium text-gray-900 ml-2 block">
                                    Complete
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                          <div class="w-full">
                            <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded w-full" type="submit">
                              Submit
                            </button>
                          </div>
                        </div>
                      </form>
                </label>
                </label>
            </div>



            <button class="{{$todo['id']}}-delmodal font-bold py-2 px-4 rounded bg-red-500 hover:bg-red-400 text-white" id="del-button" onclick="getDelClass(this.classList[0])">
                <label for="{{$todo['id']}}-delmodal" class="cursor-pointer rounded">Delete</label>
            </button>


        {{-- del modal form --}}
            <div class="">
                <input type="checkbox" id="{{$todo['id']}}-delmodal" class="peer fixed appearance-none opacity-0" />
                <label for="{{$todo['id']}}-delmodal" class="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
                <label class="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-lg overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" for="">
                    <h3 class="text-lg font-bold text-center">Warning!</h3>
                    <p class="py-4">Are you sure you want to delete this task?</p>
                    <div class="flex justify-around">
                        <button type="button" class="close-modal bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-4">
                            Close
                        </button>
                        <form method="post" action="delete/{{$todo['id']}}">
                            @method('DELETE')
                            @csrf
                            <button class="font-bold py-2 px-4 rounded bg-red-500 hover:bg-red-400 text-white" type="submit">
                                <p>Delete</p>
                            </button>
                        </form>
                    </div>
                </label>
                </label>
            </div>
      </td>
      {{-- @endif --}}
    </tr>
    @endforeach

    @else
    <p>Nothing to do, let's chill</p>
    @endif

    </tbody>
  </table>

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
