@if ($button)
    <div {{ $attributes->merge(['class' => 'flex mt-6']) }}>
        <button type="button" class="mx-auto">
            <div
                class="inline-flex items-center px-4 py-2 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                {{ $slot }}
            </div>
        </button>
    </div>
@else
    <div {{ $attributes->merge(['class' => 'flex mt-6']) }}>
        <a href="{{ $route }}" target="{{ $external ? '_blank' : '' }}"
            rel="{{ $external ? 'noopener noreferrer' : '' }}" class="mx-auto">
            <div
                class="inline-flex items-center px-4 py-2 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                {{ $slot }}
            </div>
        </a>
    </div>
@endif
