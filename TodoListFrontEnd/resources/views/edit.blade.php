<div class="z-10">
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
              @if ($user['is_admin'] != 1)
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
                        <option value="{{$todo['user']['id']}}" selected>{{$todo['user']['name']}}</option>
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

              <div class="flex items-center mb-6">
                <div class="w-1/5">
                  <label class="block text-gray-500 font-bold text-left" for="deadline">
                    Deadline:
                  </label>
                </div>
                <div class="w-4/5">
                  <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="deadline" type="datetime-local" name="deadline" value="{{$todo['deadline']}}">
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
