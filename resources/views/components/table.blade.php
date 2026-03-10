@props([
    'headers' => [],
])

<table class="dark:text-white w-full table-auto">
    <thead class="font-semibold">
        <tr>
            @foreach ($headers as $header)
                <td class="uppercase underline">
                    {{ $header }}
                </td>
            @endforeach
        </tr>
    </thead>
    <tbody class="text-sm">
        {{ $slot }}
    </tbody>
</table>
