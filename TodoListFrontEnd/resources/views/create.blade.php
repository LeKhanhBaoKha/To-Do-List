@if (strpos(url()->current(), 'login'))

@elseif (strpos(url()->current(), 'register'))

@else
<div class="z-10">
    <input type="checkbox" id="create" class="peer fixed appearance-none opacity-0" />
    <label for="create" class="pointer-events-none invisible fixed inset-0 flex cursor-pointer items-center justify-center overflow-hidden overscroll-contain bg-slate-700/30 opacity-0 transition-all duration-[0.5s] ease-in-out peer-checked:pointer-events-auto peer-checked:visible peer-checked:opacity-100 peer-checked:[&>*]:scale-100">
    <label class="max-h-[calc(100vh - 5em)] scale-99 h-fit max-w-[80%] overflow-auto overscroll-contain rounded-md bg-white p-6 text-black shadow-2xl transition" for="">
        <form class="w-[600px] m-auto px-4 py-4" action="store" method="post">
            @csrf
            <div class="flex items-center mb-6">
              <div class="w-1/5">
                <label class="block text-gray-500 font-bold text-left" for="todo name">
                  To do name:
                </label>
              </div>
              <div class="w-4/5">
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="todo name" type="text" value="" name="name">
              </div>
            </div>

            <div class="flex items-center mb-6">
              <div class="w-1/5">
                <label class="block text-gray-500 font-bold text-left" for="description">
                  Description:
                </label>
              </div>
              <div class="w-4/5">
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="description" type="text" name="description" placeholder="">
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
                        @foreach ($data['projects'] as $project)
                        <option value="{{$project['id']}}">{{$project['name']}}</option>
                        @endforeach
                    </select>
                </div>
              </div>

              <div class="flex items-center mb-6"
              @if ($userinfo['is_admin'] == 0)
              style="display:none;"
              @endif
              >
                <div class="w-1/5">
                  <label class="block text-gray-500 font-bold text-left " for="user_id">
                    Belongs to:
                  </label>
                </div>
                <div class="w-4/5">
                    <select name="user_id" id="user_id">
                        <option value="{{$userinfo['id']}}">{{$userinfo['name']}}</option>
                        @foreach ($data['users'] as $user)
                        @if ($userinfo['name'] == $user['name'])
                            @continue
                        @else
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
              </div>


            <div class="flex items-center mb-6">
                <div class="w-1/5">
                  <label class="block text-gray-500 font-bold text-left" for="description">
                    Deadline:
                  </label>
                </div>
                <div class="w-4/5">
                  <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="deadline" type="datetime-local" name="deadline" placeholder="">
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
@endif
