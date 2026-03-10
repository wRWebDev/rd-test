<x-layout>
    <x-title>Products</x-title>

    <x-table :headers="[
        'title',
        'price',
        'allocated to orders',
        'physical quantity',
        'total threshold',
        'immediate dispatch',
        '',
    ]">
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->getCurrencyAttribute('price') }}</td>
                <td>{{ $product->allocatedToOrders() }}</td>
                <td>{{ $product->physicalQuantity() }}</td>
                <td>{{ $product->totalThreshold() }}</td>
                <td>{{ $product->immediateDespatch() }}</td>
                <td class="text-right">
                    <a href="{{ route('product', $product) }}" class="hover:underline">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </x-table>
</x-layout>
