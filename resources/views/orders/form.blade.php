<x-layout>
    <x-title>
        New Order
    </x-title>
    <form action="/" method="post" class="w-full">
        @csrf
        <div class="grid grid-cols-2 gap-2">
            <div class="grid space-y-2 dark:text-white">
                <label for="product" class="@error('product') text-red-600 @enderror">
                    Select a product
                </label>
                <select name="product" class="w-full max-w-md bg-stone-800 p-2">
                    @foreach ($products as $product)
                        <option value="{{ $product->uuid }}">
                            {{ $product->title }}
                        </option>
                    @endforeach
                </select>
                @error('product')
                    <p class="text-red-600 text-sm text-balance">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="grid space-y-2 dark:text-white">
                <label for="quantity" class="@error('quantity') text-red-600 @enderror">
                    Enter a quantity
                </label>
                <input name="quantity" class="w-full max-w-md bg-stone-800 p-2" type="number" min="1"
                    increment="1" value="1" />
                @error('quantity')
                    <p class="text-red-600 text-sm text-balance">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <div class="flex justify-end mt-8">
            <button class="bg-stone-200 py-2 px-4 uppercase rounded-md cursor-pointer">
                Place order
            </button>
        </div>
    </form>
</x-layout>
