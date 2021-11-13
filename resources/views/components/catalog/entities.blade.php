@if (sizeof($entities))
    <x-catalog.line>
        <h3
            style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial,helvetica,sans-serif; font-size: 22px;">
            <strong>
                {{ ucfirst($type) }}
            </strong>
        </h3>
    </x-catalog.line>
    @foreach (array_chunk($entities, 3) as $chunk)
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 800px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                @foreach ($chunk as $item)
                    @php
                        $route = route('features.catalog.index');
                        switch ($type) {
                            case 'book':
                                $route = route('features.catalog.books.show', [
                                    'author' => $item->meta?->author,
                                    'book' => $item->meta?->slug,
                                ]);
                                break;
                        
                            case 'serie':
                                $route = route('features.catalog.series.show', [
                                    'author' => $item->meta?->author,
                                    'serie' => $item->meta?->slug,
                                ]);
                                break;
                        
                            case 'author':
                                $route = route('features.catalog.authors.show', [
                                    'character' => $item->first_char,
                                    'author' => $item->meta?->slug,
                                ]);
                                break;
                        
                            default:
                                # code...
                                break;
                        }
                    @endphp
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:800px;"><tr style="background-color: transparent;"><![endif]-->

                    <!--[if (mso)|(IE)]><td align="center" width="167" style="width: 167px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                    <a href="{{ $route }}" class="u-col u-col-33p33"
                        style="max-width: 320px;min-width: 167px;display: table-cell;vertical-align: top;">
                        <div style="width: 100% !important;">
                            <!--[if (!mso)&(!IE)]><!-->
                            <div
                                style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                <!--<![endif]-->

                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                    cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                align="left">

                                                <div
                                                    style="line-height: 140%; text-align: center; word-wrap: break-word; width: 200px">
                                                    <img src="{{ $item->cover?->simple }}" alt="{{ $item->title }}"
                                                        style="height: 200px; width: 200px; object-fit: cover">
                                                    <h2 style="font-size: 14px; line-height: 140%;">
                                                        {{ $item->title }}
                                                    </h2>
                                                    @if ($type !== 'author')
                                                        @isset($item->authors)
                                                            <div>
                                                                <i>Authors</i> : @foreach ($item->authors as $author)
                                                                    {{ $author->name }}
                                                                @endforeach
                                                            </div>
                                                        @endisset
                                                    @endif
                                                    @isset($item->language)
                                                        <div>
                                                            <i>Language</i> : {{ $item->language }}
                                                        </div>
                                                    @endisset
                                                    @isset($item->serie)
                                                        <div>
                                                            <i>Serie</i> :
                                                            {{ $item->serie }},
                                                            vol. {{ $item->volume }}
                                                        </div>
                                                    @endisset
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--[if (!mso)&(!IE)]><!-->
                            </div>
                            <!--<![endif]-->
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

@endif
