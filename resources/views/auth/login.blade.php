<x-guest-layout>
    <div class="fl-head">
        <h1>Selamat datang kembali</h1>
        <p>Masuk untuk memesan layanan atau mengelola pekerjaanmu.</p>
    </div>

    @if (session('status'))
        <div class="fl-alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="fl-field">
            <label class="fl-label" for="email">Email</label>
            <div class="fl-input-wrap">
                <i class="bi bi-envelope fl-ico"></i>
                <input id="email" class="fl-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="username">
            </div>
            @error('email') <div class="fl-error">{{ $message }}</div> @enderror
        </div>

        <div class="fl-field">
            <label class="fl-label" for="password">Password</label>
            <div class="fl-input-wrap">
                <i class="bi bi-lock fl-ico"></i>
                <input id="password" class="fl-input has-eye @error('password') is-invalid @enderror" type="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                <button type="button" class="fl-eye" data-toggle-pass="password"><i class="bi bi-eye"></i></button>
            </div>
            @error('password') <div class="fl-error">{{ $message }}</div> @enderror
        </div>

        <div class="fl-row">
            <label class="fl-remember">
                <input type="checkbox" name="remember" class="fl-check"> Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a class="fl-link" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <button class="fl-btn">Masuk</button>
    </form>

    <div class="fl-foot">
        Belum punya akun? <a class="fl-link" href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</x-guest-layout>