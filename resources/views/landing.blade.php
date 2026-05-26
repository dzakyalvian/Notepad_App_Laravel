<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Notepad') }} — Catat Apapun, Kapanpun</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #1a1a1a;
            --surface:   #242424;
            --surface2:  #2a2a2a;
            --border:    #2e2e2e;
            --border2:   #3a3a3a;
            --text:      #f5f5f5;
            --muted:     #a3a3a3;
            --faint:     #525252;
            --orange:    #ea580c;
            --orange-dk: #c2410c;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ── NAV ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 50;
            background: rgba(26, 26, 26, 0.85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 30px;
            height: 30px;
            background: var(--orange);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: -0.02em;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }

        .nav-links a {
            font-size: 0.875rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--text); }

        .btn-nav {
            padding: 0.45rem 1.1rem;
            border-radius: 7px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.15s;
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border2);
        }

        .btn-ghost:hover {
            color: var(--text);
            border-color: var(--muted);
        }

        .btn-orange {
            background: var(--orange);
            color: #fff;
            border: none;
        }

        .btn-orange:hover {
            background: var(--orange-dk);
            transform: translateY(-1px);
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 6rem 1.5rem 4rem;
            position: relative;
        }

        /* subtle radial glow */
        .hero::before {
            content: '';
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(234, 88, 12, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-inner {
            max-width: 720px;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.3rem 0.875rem;
            background: var(--surface);
            border: 1px solid var(--border2);
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 1.75rem;
        }

        .hero-badge span {
            width: 6px;
            height: 6px;
            background: var(--orange);
            border-radius: 50%;
            display: inline-block;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
            color: var(--text);
            margin-bottom: 1.25rem;
        }

        .hero h1 em {
            font-style: normal;
            color: var(--orange);
        }

        .hero p {
            font-size: 1.0625rem;
            color: var(--muted);
            line-height: 1.7;
            max-width: 520px;
            margin: 0 auto 2.25rem;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.875rem;
            flex-wrap: wrap;
        }

        .btn-lg {
            padding: 0.75rem 1.75rem;
            border-radius: 9px;
            font-size: 0.9375rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-lg.orange {
            background: var(--orange);
            color: #fff;
            border: none;
        }

        .btn-lg.orange:hover {
            background: var(--orange-dk);
            transform: translateY(-1px);
        }

        .btn-lg.ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border2);
        }

        .btn-lg.ghost:hover {
            color: var(--text);
            border-color: var(--muted);
        }

        /* ── APP PREVIEW ── */
        .preview-wrap {
            max-width: 900px;
            margin: 4rem auto 0;
            padding: 0 1.5rem;
        }

        .preview-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .preview-topbar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            background: var(--surface2);
        }

        .preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border2);
        }

        .preview-body {
            display: flex;
            height: 360px;
        }

        .preview-sidebar {
            width: 180px;
            flex-shrink: 0;
            border-right: 1px solid var(--border);
            padding: 1rem 0.75rem;
            background: var(--surface2);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-btn-new {
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: default;
            margin-bottom: 6px;
            text-align: center;
        }

        .sidebar-item {
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sidebar-item.active {
            background: var(--border);
            color: var(--text);
        }

        .preview-main {
            flex: 1;
            padding: 1.25rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            align-content: start;
        }

        .preview-note {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.875rem;
        }

        .preview-note-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
        }

        .preview-note-body {
            font-size: 11px;
            color: var(--faint);
            line-height: 1.5;
        }

        .preview-tag {
            display: inline-block;
            margin-top: 8px;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 10px;
        }

        .tag-work   { background: #1a3d24; color: #34d399; }
        .tag-idea   { background: #3d2a0d; color: #fbbf24; }
        .tag-study  { background: #122b52; color: #60a5fa; }
        .tag-personal { background: #3d2b7a; color: #a78bfa; }

        /* ── FEATURES ── */
        .features {
            max-width: 1100px;
            margin: 0 auto;
            padding: 6rem 1.5rem;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--orange);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text);
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: border-color 0.2s;
        }

        .feature-card:hover {
            border-color: var(--border2);
        }

        .feature-icon {
            width: 38px;
            height: 38px;
            background: rgba(234, 88, 12, 0.12);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--orange);
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.875rem;
            color: var(--muted);
            line-height: 1.65;
        }

        /* ── CTA ── */
        .cta {
            border-top: 1px solid var(--border);
            text-align: center;
            padding: 5rem 1.5rem;
        }

        .cta h2 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text);
            margin-bottom: 0.875rem;
        }

        .cta p {
            font-size: 1rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            padding: 1.75rem 1.5rem;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-copy {
            font-size: 0.8125rem;
            color: var(--faint);
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: 0.8125rem;
            color: var(--faint);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--muted); }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav>
        <div class="nav-inner">
            <a href="/" class="brand">
                <div class="brand-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <span class="brand-name">{{ config('app.name', 'Notepad') }}</span>
            </a>

            <div class="nav-links">
                <a href="#features">Fitur</a>
                <a href="#preview">Preview</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav btn-orange">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav btn-ghost">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nav btn-orange">Daftar Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge">
                <span></span>
                Gratis selamanya · Tanpa iklan
            </div>

            <h1>Catatanmu, <em>lebih rapi</em><br>dari sebelumnya.</h1>

            <p>Tulis ide, to-do, catatan harian, atau apapun. Simpel, cepat, dan selalu tersimpan aman di satu tempat.</p>

            <div class="hero-actions">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-lg orange">
                        Mulai Gratis
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @endif
                <a href="#preview" class="btn-lg ghost">Lihat Preview</a>
            </div>
        </div>
    </section>

    <!-- APP PREVIEW -->
    <section id="preview">
        <div class="preview-wrap">
            <div class="preview-card">
                <div class="preview-topbar">
                    <div class="preview-dot"></div>
                    <div class="preview-dot"></div>
                    <div class="preview-dot"></div>
                </div>
                <div class="preview-body">
                    <!-- Sidebar -->
                    <div class="preview-sidebar">
                        <div class="sidebar-btn-new">+ New note</div>
                        <div class="sidebar-item active">☰ All notes <span style="margin-left:auto;color:var(--faint);font-size:11px;">12</span></div>
                        <div class="sidebar-item">★ Favorites</div>
                        <div class="sidebar-item">🗑 Trash</div>
                    </div>
                    <!-- Notes grid preview -->
                    <div class="preview-main">
                        <div class="preview-note">
                            <div class="preview-note-title">Rencana Minggu Ini</div>
                            <div class="preview-note-body">Selesaikan laporan, beli bahan makanan, hubungi tim...</div>
                            <span class="preview-tag tag-work">Work</span>
                        </div>
                        <div class="preview-note">
                            <div class="preview-note-title">Ide Aplikasi Baru</div>
                            <div class="preview-note-body">Bikin tracker kebiasaan harian yang terintegrasi dengan...</div>
                            <span class="preview-tag tag-idea">Idea</span>
                        </div>
                        <div class="preview-note">
                            <div class="preview-note-title">Catatan Kuliah</div>
                            <div class="preview-note-body">Bab 3 — Algoritma sorting: bubble sort, merge sort...</div>
                            <span class="preview-tag tag-study">Study</span>
                        </div>
                        <div class="preview-note">
                            <div class="preview-note-title">Wishlist Buku</div>
                            <div class="preview-note-body">Atomic Habits, Deep Work, The Psychology of Money...</div>
                            <span class="preview-tag tag-personal">Personal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="features">
        <p class="section-label">Kenapa Notepad?</p>
        <h2 class="section-title">Semua yang kamu butuhkan,<br>tidak lebih.</h2>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="feature-title">Cepat & Ringan</div>
                <div class="feature-desc">Tanpa loading lama. Buka, tulis, simpan — semua dalam hitungan detik.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div class="feature-title">Organisasi dengan Tag</div>
                <div class="feature-desc">Kelompokkan catatan dengan tag — Work, Idea, Study, Personal, atau buat sendiri.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div class="feature-title">Favorit & Arsip</div>
                <div class="feature-desc">Tandai catatan penting sebagai favorit. Hapus sementara ke trash, atau hapus permanen.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div class="feature-title">Cari Dengan Mudah</div>
                <div class="feature-desc">Ketik, dan catatanmu langsung muncul. Pencarian real-time tanpa reload halaman.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div class="feature-title">Privasi Terjaga</div>
                <div class="feature-desc">Catatanmu hanya bisa dilihat oleh kamu. Tidak ada yang bisa mengaksesnya selain akun milikmu.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <div class="feature-title">Tersimpan di Cloud</div>
                <div class="feature-desc">Buka dari perangkat manapun. Catatanmu selalu ada selama ada koneksi internet.</div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2>Siap mulai mencatat?</h2>
        <p>Gratis, tanpa kartu kredit, tanpa batasan catatan.</p>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-lg orange">
                Buat Akun Gratis
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        @endif
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-inner">
            <div class="footer-copy">© {{ date('Y') }} {{ config('app.name', 'Notepad') }}. Dibuat dengan ❤️</div>
            <div class="footer-links">
                <a href="#">Privasi</a>
                <a href="#">Syarat</a>
                <a href="#">Kontak</a>
            </div>
        </div>
    </footer>

</body>
</html>
