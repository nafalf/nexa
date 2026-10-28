<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nexa — Beranda</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<main class="app-shell">
    <header class="topbar">
        <div class="brand"><span></span>nexa</div>
        @if($demoMode)
            <a class="outline" href="{{ route('home') }}">Masuk</a>
        @else
            <form method="post" action="{{ route('logout') }}">@csrf<button class="outline">Keluar</button></form>
        @endif
    </header>
    <section class="welcome">
        <div class="avatar">{{ substr($user->name, 0, 1) }}</div>
        <div><p class="eyebrow">Selamat pagi</p><h1>Hai, {{ explode(' ', $user->name)[0] }}.</h1></div>
        <div class="header-actions"><button class="icon-button">Notifikasi</button></div>
    </section>
    <nav class="segmented"><button>Insights</button><button class="active">Transaksi</button><button>Growth</button></nav>
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert error">{{ $errors->first() }}</div>
    @endif
    <section class="section-head"><h2>Rekening transaksi kamu</h2><a href="#rekening">Lihat semua</a></section>
    <section class="account-row">
        <div class="asset-card"><span class="asset-icon">◔</span><strong>Lihat<br>Aset</strong></div>
        <article class="balance-card"><div class="card-orb"></div><div class="card-content">
            <div>Nexa Tabungan <span class="pill">UTAMA</span></div>
            <strong class="account-no">{{ $account->number }}</strong><span class="total-label">Total saldo</span>
            <div class="balance"><span id="balanceValue">Rp{{ number_format($account->balance, 0, ',', '.') }}</span><button id="toggleBalance">Tampilkan</button></div>
        </div></article>
    </section>
    <div class="dots"><b></b><i></i><i></i></div>
    <section class="section-head"><h2>Akses cepat</h2></section>
    <section class="feature-grid compact-features">
        <a href="#transfer" class="feature"><span class="feature-icon turquoise">Transfer</span><b>Kirim dana</b></a>
        <a href="#rekening" class="feature"><span class="feature-icon orange">Riwayat</span><b>Riwayat transaksi</b></a>
        <a href="#rekening" class="feature"><span class="feature-icon blue">Rekening</span><b>Detail rekening</b></a>
    </section>
    <section id="transfer" class="panel">
        <div class="section-head"><h2>Transfer dana</h2></div>
        @if($demoMode)
            <p class="muted">Mode demo hanya untuk melihat tampilan. Masuk untuk mencoba transfer.</p>
            <a class="primary demo-link" href="{{ route('home') }}">Masuk untuk mencoba</a>
        @else
        <form method="post" action="{{ route('transfer') }}">@csrf
            <label>Rekening tujuan
                <select name="beneficiary_id" required>
                    @foreach($beneficiaries as $b)
                        <option value="{{ $b->id }}">{{ $b->name }} — {{ $b->bank }}</option>
                    @endforeach
                </select>
            </label>
            <label>Nominal<input type="number" name="amount" min="10000" placeholder="Minimal Rp10.000" required></label>
            <label>OTP simulasi<input type="text" name="otp" inputmode="numeric" placeholder="Gunakan 123456" required></label>
            <button class="primary" type="submit">Kirim transfer</button>
        </form>
        @endif
    </section>
    <section id="rekening" class="panel">
        <div class="section-head"><h2>Transaksi terakhir</h2></div>
        @forelse($transactions as $t)
            <div class="transaction"><div><strong>{{ $t->description ?: 'Transaksi' }}</strong><small>{{ $t->created_at->format('d M Y, H:i') }} · {{ $t->status }}</small></div><b class="debit">- Rp{{ number_format($t->amount, 0, ',', '.') }}</b></div>
        @empty
            <p class="muted">Belum ada transaksi.</p>
        @endforelse
    </section>
    <footer class="bottom-nav"><a class="selected" href="{{ route('dashboard') }}"><span class="nav-icon">⌂</span>Beranda</a><a href="{{ route('activity') }}"><span class="nav-icon">≡</span>Aktivitas</a><a href="{{ route('transfer.page') }}"><span class="nav-icon">↗</span>Transfer</a><a href="{{ route('profile') }}"><span class="nav-icon">○</span>Profil</a></footer>
</main>
</body>
</html>
