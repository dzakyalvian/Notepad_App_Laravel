<x-guest-layout>

    <h1 class="auth-title">Selamat datang kembali</h1>
    <p class="auth-subtitle">Masuk ke akun kamu untuk melanjutkan.</p>

    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-input"
                value="{{ old('email') }}"
                placeholder="kamu@email.com"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <div class="form-label-row">
                <label for="password" class="form-label" style="margin-bottom:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            >
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
            <label for="remember_me" class="checkbox-label">Ingat saya</label>
        </div>

        <button type="submit" class="btn-auth">Masuk</button>
    </form>

    <p class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </p>

</x-guest-layout>
