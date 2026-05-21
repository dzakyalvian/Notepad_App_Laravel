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
            box-shadow: none !important;
        }

        .btn-edit {
            background: none;
            border: none;
            cursor: pointer;
            color: #525252;
            font-size: 14px;
            transition: color 0.2s;
            position: relative;
        }

        .btn-edit:hover {
            color: #3b82f6;
        }

        .btn-delete {
            background: none;
            border: none;
            cursor: pointer;
            color: #525252;
            font-size: 14px;
            transition: color 0.2s;
            position: relative;
        }

        .btn-delete:hover {
            color: #f87171;
        }

        .btn-star {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s;
            position: relative;
        }

        .btn-star:hover {
            color: #facc15;
        }

        * {
            outline: none !important;
            box-sizing: border-box;
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
            background: #2e2e2e;
            color: #e5e5e5;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
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

<body style="background:#1a1a1a; margin:0;">

    {{-- NAVBAR --}}
    <nav
        style="background:#1f1f1f; border-bottom:1px solid #2e2e2e; padding:12px 1.5rem; display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="font-size:18px; color:#9E9E9E;"><i class="fa-solid fa-clipboard"></i></span>
            <span style="font-weight:600; color:#f5f5f5; font-size:16px;">MyNotepad</span>
        </div>

        <div style="position:relative;">
            <button id="avatarBtn"
                style="width:34px; height:34px; border-radius:50%; background:#ea580c; border:none; cursor:pointer; color:white; font-size:14px; font-weight:600; overflow:hidden; padding:0;">
                @if (auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                        style="width:100%; height:100%; object-fit:cover;">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </button>

            <div id="dropdown"
                style="position:absolute; right:0; top:42px; background:#242424; border:1px solid #2e2e2e; border-radius:10px; padding:8px; min-width:160px; z-index:99;">
                <p
                    style="font-size:12px; color:#525252; padding:6px 10px; border-bottom:1px solid #2e2e2e; margin-bottom:6px;">
                    {{ auth()->user()->name }}
                </p>
                <a href="/edit-profile"
                    style="display:block; color:#e5e5e5; font-size:13px; padding:7px 10px; border-radius:6px; text-decoration:none;">
                    👤 Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        style="width:100%; text-align:left; background:none; border:none; color:#f87171; font-size:13px; padding:7px 10px; cursor:pointer; border-radius:6px;">
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
