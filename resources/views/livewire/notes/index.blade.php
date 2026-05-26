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

        .dark [data-tooltip]::after {
            background: #e8eaed;
            color: #202124;
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-keep-bg dark:bg-[#202124] m-0 font-sans antialiased text-keep-textPrimary dark:text-[#e8eaed] transition-colors duration-200">

    {{-- NAVBAR --}}
    <nav class="bg-keep-navbar dark:bg-[#202124] border-b border-keep-border/60 dark:border-[#5f6368] py-3 px-4 sm:px-6 flex justify-between items-center sticky top-0 z-40">
        <div class="flex items-center gap-2 sm:gap-4">
            <button id="mobileMenuBtn" class="sm:hidden text-keep-textSecondary dark:text-[#9aa0a6] hover:bg-keep-bg dark:hover:bg-[#3c4043] rounded-full p-2 w-10 h-10 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="flex items-center gap-2">
                <span class="text-lg text-brand-primary"><i class="fa-solid fa-clipboard"></i></span>
                <span class="font-semibold text-keep-textPrimary dark:text-[#e8eaed] text-base tracking-tight font-sans hidden sm:inline-block">MyNotepad</span>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            {{-- THEME TOGGLE --}}
            <button id="themeToggleBtn" class="text-keep-textSecondary dark:text-[#9aa0a6] hover:bg-keep-bg dark:hover:bg-[#3c4043] rounded-full p-2 w-10 h-10 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-moon" id="themeIcon"></i>
            </button>

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
                class="absolute right-0 top-[42px] bg-keep-navbar dark:bg-[#28292c] border border-keep-border dark:border-[#5f6368] rounded-lg p-1.5 min-w-[160px] z-50 shadow-lg">
                <p class="text-[11px] font-sans text-keep-textSecondary/80 dark:text-[#9aa0a6] font-medium px-2.5 py-1 border-b border-keep-bg dark:border-[#5f6368] m-0 mb-1.5">
                    {{ auth()->user()->name }}
                </p>
                <a href="/edit-profile" class="block text-keep-textBody dark:text-[#e8eaed] text-xs px-3 py-2 rounded-md no-underline transition-colors hover:bg-keep-bg dark:hover:bg-[#3c4043]">
                    👤 Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left bg-transparent border-none text-[#d93025] dark:text-[#f28b82] text-xs px-3 py-2 cursor-pointer rounded-md transition-colors hover:bg-[#fce8e6] dark:hover:bg-[#3c4043]">
                        🚪 Logout
                    </button>
                </form>
            </div>
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

        // Theme Toggle
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        
        function updateIcon() {
            if (document.documentElement.classList.contains('dark')) {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            } else {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        }
        updateIcon();

        themeToggleBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            updateIcon();
        });

        // Mobile Sidebar Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if(mobileMenuBtn && sidebar && sidebarOverlay) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            });

            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }
    </script>
</body>

</html>
