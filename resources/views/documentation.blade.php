<ul class="list-none space-y-3 pl-4">
    <li>
        <a href="introduction" class="font-semibold text-gray-600 hover:text-blue-600">Introduction</a>
    </li>

    @foreach ($groupedEndpoints as $name => $grouped)
    <li>
        <p class="font-bold text-gray-500 uppercase pb-1">{{ $name }}</p>

        <ul class="space-y-2">
            @foreach ($grouped as $endpoint)
            <li class="pl-4">
                <a
                    href="{{ $endpoint->getFilePath() }}"
                    class="font-semibold text-gray-600 hover:text-blue-600"
                >
                    {{ $endpoint->route->description }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
    @endforeach
</ul>

