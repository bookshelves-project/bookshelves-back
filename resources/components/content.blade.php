<div {{ $attributes->merge(['class' => 'dark']) }}>
    @if ($date)
        <div class="text-sm italic">
            Last update: {{ $date }}
        </div>
    @endif
    <div
        class="prose prose-lg prose-invert mt-6 prose-headings:font-handlee word-wraping {{ $full ? 'max-w-full' : '' }}">
        {{ $title ?? '' }}
        {!! $content !!}
        {{ $slot }}
    </div>

</div>
