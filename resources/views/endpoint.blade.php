## {!! $endpoint->group !!}

@if ($endpoint->authenticated)
<span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
    Requires authentication
</span>
@endif

{!! $endpoint->route->description !!}

<div class="flex space-x-2 items-center">
    <span class="inline-flex items-center px-3 py-1 rounded-md font-medium bg-green-100 text-green-800 uppercase">
        {!! $endpoint->route->method !!}
    </span>

    <span class="font-mono">{{ $endpoint->route->uri }}</span>
</div>

@if (count($endpoint->urlParameters))
<div class="mt-4 divide-y divide-gray-300">
    <p class="font-bold">URL parameters</p>

    @foreach ($endpoint->urlParameters as $parameter)
    <div>
        <p>
            <span class="font-bold">{{ $parameter->name }}</span> <span class="ml-1">{{ $parameter->type }}</span>
            @if ($parameter->required)
            <span class="uppercase text-red-800 ml-1">required</span>
            @else
            <span class="text-gray-500 ml-1">optional</span>
            @endif
        </p>
        <p>{{ $parameter->description }}</p>
    </div>
    @endforeach
</div>
@endif

@if (count($endpoint->bodyParameters))
<div class="mt-4 divide-y divide-gray-300">
    <p class="font-bold">Body parameters</p>

    @foreach ($endpoint->bodyParameters as $parameter)
    <div>
        <p>
            <span class="font-bold">{{ $parameter->name }}</span> <span class="ml-1">{{ $parameter->type }}</span>
            @if ($parameter->required)
            <span class="uppercase text-red-800 ml-1">required</span>
            @else
            <span class="text-gray-500 ml-1">optional</span>
            @endif
        </p>
        <p>{{ $parameter->description }}</p>
    </div>
    @endforeach
</div>
@endif

@if (count($endpoint->responses))
<div class="mt-4 divide-y divide-gray-300">
    <p class="font-bold">Responses</p>
    @foreach ($endpoint->responses as $response)
    <div>
        <p class="flex items-center">
            <span class="mr-2 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-300 text-gray-800">
                {{ $response->status }}
            </span>
            {{ $response->scenario }}
        </p>
        @if ($response->example)
        <pre>{{ json_encode($response->example, JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
    @endforeach
</div>
@endif


