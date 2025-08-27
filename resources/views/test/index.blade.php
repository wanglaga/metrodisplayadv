<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Kontak</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 2em;
        }

        .contact-info {
            border: 1px solid #ccc;
            padding: 1em;
            border-radius: 8px;
            max-width: 400px;
            margin: 0 auto;
        }

        .contact-info h2 {
            margin-top: 0;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 0.5em;
        }

        li a {
            text-decoration: none;
            color: #007bff;
        }

        .no-data {
            color: #888;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="contact-info">
        @if (Request::route('slug'))
            <h2>Kontak User</h2>
            <ul>
                @php
                    // Pastikan $socialMedia_user itu object tunggal, bukan collection
                    $sm = is_iterable($socialMedia) ? null : $socialMedia;
                @endphp

                @if ($sm && $sm->whatsapp_number)
                    <li><a href="{{ $sm->whatsapp_number }}">{{ $sm->whatsapp_number }}</a></li>
                @endif
                @if ($sm && $sm->tokopedia)
                    <li><a href="{{ $sm->tokopedia }}">Tokopedia</a></li>
                @endif
                @if ($sm && $sm->instagram)
                    <li><a href="{{ $sm->instagram }}">Instagram</a></li>
                @endif
                @if ($sm && $sm->facebook)
                    <li><a href="{{ $sm->facebook }}">Facebook</a></li>
                @endif
                @if ($sm && $sm->tiktok)
                    <li><a href="{{ $sm->tiktok }}">TikTok</a></li>
                @endif
            </ul>

            @if (!($sm && ($sm->tokopedia || $sm->instagram || $sm->facebook || $sm->tiktok)))
                {{-- fallback ke data default dari tabel social_media --}}
                <ul>
                    @forelse($defaultSocialMedia as $item)
                        <li><a href="{{ $item->link }}">{{ $item->nama_sosmed }}</a></li>
                    @empty
                        <p class="no-data">Maaf, data sosial media tidak tersedia.</p>
                    @endforelse
                </ul>
            @endif
        @else
            <h2>Kontak Perusahaan</h2>
            <ul>
                @forelse($socialMedia as $item)
                    <li><a href="{{ $item->link }}">{{ $item->nama_sosmed }}</a></li>
                @empty
                    <p class="no-data">Maaf, data sosial media perusahaan tidak tersedia.</p>
                @endforelse
            </ul>
        @endif
    </div>

    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('faq') }}">FAQ</a>

</body>

</html>
