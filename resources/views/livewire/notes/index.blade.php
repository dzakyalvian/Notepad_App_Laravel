<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotepad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body style="background:#1a1a1a; margin:0;">

    {{-- NAVBAR --}}
    <nav style="background:#1f1f1f; border-bottom:1px solid #2e2e2e; padding:12px 1.5rem; display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="font-size:18px;">📓</span>
            <span style="font-weight:600; color:#f5f5f5; font-size:16px;">MyNotepad</span>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span style="color:#a3a3a3; font-size:14px;">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none; border:none; color:#525252; cursor:pointer; font-size:13px;">Logout</button>
            </form>
        </div>
    </nav>

    <livewire:notes.note-list />

    @livewireScripts
</body>
</html>
