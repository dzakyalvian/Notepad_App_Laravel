<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - MyNotepad</title>
    {{-- Preconnect biar CDN lebih cepet --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" media="print"
        onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>
</head>
<body class="bg-keep-bg text-keep-textPrimary font-sans m-0 antialiased">

    <nav class="bg-keep-navbar border-b border-keep-border/60 py-3 px-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-lg text-brand-primary"><i class="fa-solid fa-clipboard"></i></span>
            <span class="font-semibold text-keep-textPrimary text-base tracking-tight">MyNotepad</span>
        </div>
    </nav>

    <livewire:profile.edit-profile />

    @livewireScripts
</body>
</html>
