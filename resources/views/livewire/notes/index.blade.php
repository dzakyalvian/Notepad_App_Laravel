<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotepad</title>

    {{-- Preconnect biar CDN lebih cepet --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Font Awesome dengan display swap biar ga block render --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" media="print"
        onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>

    <style>
        *,
        *::before,
        *::after {
            outline: none !important;
        }

        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            background: #202124;
            color: #ffffff;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            z-index: 100;
        }

        [data-tooltip]:hover::after {
            opacity: 1;
        }

        #dropdown {
            display: none;
        }

        #dropdown.show {
            display: block;
        }
    </style>
</head>

<body class="bg-keep-bg m-0 font-sans antialiased text-keep-textPrimary">

    {{-- NAVBAR --}}
    <nav class="bg-keep-navbar border-b border-keep-border/60 py-3 px-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-lg text-brand-primary"><i class="fa-solid fa-clipboard"></i></span>
            <span class="font-semibold text-keep-textPrimary text-base tracking-tight font-sans">MyNotepad</span>
        </div>

        <div class="relative">
            <button id="avatarBtn"
                class="w-[34px] h-[34px] rounded-full bg-brand-primary border-none cursor-pointer text-white text-sm font-semibold overflow-hidden p-0 flex items-center justify-center">
                @if (auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                        class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </button>

            <div id="dropdown"
                class="absolute right-0 top-[42px] bg-keep-navbar border border-keep-border rounded-lg p-1.5 min-w-[160px] z-50 shadow-lg">
                <p class="text-[11px] font-sans text-keep-textSecondary/80 font-medium px-2.5 py-1 border-b border-keep-bg m-0 mb-1.5">
                    {{ auth()->user()->name }}
                </p>
                <a href="/edit-profile" class="block text-keep-textBody text-xs px-3 py-2 rounded-md no-underline transition-colors hover:bg-keep-bg hover:text-keep-textPrimary">
                    👤 Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left bg-transparent border-none text-[#d93025] text-xs px-3 py-2 cursor-pointer rounded-md transition-colors hover:bg-[#fce8e6]">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <livewire:notes.note-list />

    @livewireScripts

    <script>
        // Dropdown toggle
        const btn = document.getElementById('avatarBtn');
        const dropdown = document.getElementById('dropdown');
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });
        // Tutup kalo klik di luar
        document.addEventListener('click', () => {
            dropdown.classList.remove('show');
        });
    </script>
</body>

</html>
