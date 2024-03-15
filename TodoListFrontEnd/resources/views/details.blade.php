<div class="z-10">
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
        <p class="py-1">Starting date: {{ \Carbon\Carbon::parse($todo['created_at'])->format('Y-m-d H:i:s') }}</p>
        {{-- <p class="py-1">{{$todo['created_at']}}</p> --}}
        <p class="py-1">Deadline: {{$todo['deadline']}}</p>
    </label>
    </label>
</div>
