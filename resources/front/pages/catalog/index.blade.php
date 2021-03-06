<x-layouts.main>
    <x-content :content="$content">
        <div class="mx-auto w-max mt-6">
            <x-button :route="route('front.catalog.search')">
                Access to Catalog
            </x-button>
        </div>
        <div class="mt-3">
            To access to Catalog from your eReader, just put this address to your web browser*:
            <pre>{{ route('front.catalog') }}</pre>
            <div class="mt-3">
                <small>
                    *: Works only on phone, tablet or eReader.
                </small>
            </div>
        </div>
    </x-content>
</x-layouts.main>
