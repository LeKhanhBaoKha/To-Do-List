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
