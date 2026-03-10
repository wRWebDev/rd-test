<x-layout>
    <h1 class="text-2xl dark:text-white font-bold">{{ $product->title }}</h1>

    <p class="text-lg dark:text-white font-medium mt-2">
        {{ $product->price / 100 }}
    </p>

    <p class="text-md dark:text-white mt-2 text-center text-balance">
        {{ $product->description }}
    </p>

    <x-subtitle>
        Stats
    </x-subtitle>

    <x-table :headers="['stat', 'value']">
        <tr>
            <td>
                Allocated to orders
            </td>
            <td>
                {{ $product->allocatedToOrders() }}
            </td>
        </tr>
        <tr>
            <td>
                Physical quantity
            </td>
            <td>
                {{ $product->physicalQuantity() }}
            </td>
        </tr>
        <tr>
            <td>
                Total threshold
            </td>
            <td>
                {{ $product->totalThreshold() }}
            </td>
        </tr>
        <tr>
            <td>
                Immediate despatch
            </td>
            <td>
                {{ $product->immediateDespatch() }}
            </td>
        </tr>
    </x-table>

    <x-subtitle>
        Stock
    </x-subtitle>

    <x-table :headers="['warehouse', 'quantity', 'threshold', '']">
        @foreach ($product->warehouses as $warehouse)
            <tr>
                <td>{{ $warehouse->name }}</td>
                <td>{{ $warehouse->stock->quantity }}</td>
                <td class="p-2">{{ $warehouse->stock->threshold }}</td>
                <td>
                    <a href="{{ $warehouse->getMapsLink() }}" class="hover:underline" target="blank"
                        rel="noopener noreferrer">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </x-table>

</x-layout>
