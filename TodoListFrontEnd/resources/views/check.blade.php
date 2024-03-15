@if($todo['state'] == 0)
<button class="font-bold py-1 px-2 rounded bg-purple-500  hover:text-green-500 text-white mr-2 transition duration-[0.5s] ease-in-out"
onclick="event.preventDefault(); document.getElementById('complete_form{{$todo['id']}}').submit()">
    <x-fas-check class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px] "/>
</button>

<div>
    <form class="w-[600px] m-auto px-4 py-4 hidden" action="update" method="post" id="complete_form{{$todo['id']}}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" value={{$todo['id']}} style="display:none">
        <input type="hidden" name="state" value="1" style="display:none">
    </form>
</div>
@else
    <button class="font-bold py-1 px-2 rounded bg-purple-500  hover:text-red-500 text-white mr-2 "
    onclick="event.preventDefault(); document.getElementById('incomplete_form{{$todo['id']}}').submit()">
        <x-fas-x class="sm:w-[15px] sm:h-[19px] md:w-[20px] md:h-[24px] lg:w-[30px] lg:h-[34px]"/>
    </button>

    <div>
        <form class="w-[600px] m-auto px-4 py-4 hidden" action="update" method="post" id="incomplete_form{{$todo['id']}}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value={{$todo['id']}} style="display:none">
            <input type="hidden" name="state" value="0" style="display:none">
        </form>
    </div>
@endif
