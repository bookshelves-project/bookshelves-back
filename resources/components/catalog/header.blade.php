<tr>
    <td class="header">
        <a href="{{ route('front.catalog.search') }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ asset('assets/images/icon.png') }}" class="logo" alt="Laravel Logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
