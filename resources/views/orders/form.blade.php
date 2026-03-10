<x-layout>
    <x-title>
        New Order
    </x-title>
    <form action="/" method="post" class="w-full">
        @csrf
        <div class="flex justify-end">
            <button class="bg-stone-200 py-2 px-4 uppercase rounded-md cursor-pointer">
                Place order
            </button>
        </div>
    </form>
</x-layout>
