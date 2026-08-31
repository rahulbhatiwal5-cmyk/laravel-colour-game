<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lottery777 — My Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; background: #f3f4f6; color: #1a1a2e; font-family: 'Nunito', sans-serif; }
        .app { width: 100%; max-width: 430px; min-height: 100vh; margin: 0 auto; background: #f3f4f6; }
        .header { padding: 14px 16px 64px; background: linear-gradient(135deg, #e8192c, #b91c1c); border-radius: 0 0 28px 28px; }
        .header-top { display: flex; align-items: center; justify-content: space-between; }
        .back-btn { display: grid; width: 34px; height: 34px; place-items: center; border-radius: 50%; background: rgba(255,255,255,.18); color: #fff; text-decoration: none; font-size: 25px; line-height: 1; }
        .header-title { color: #fff; font: 800 21px 'Baloo 2', cursive; }
        .header-spacer { width: 34px; }
        .profile-card { margin: -44px 16px 18px; padding: 22px 18px; border-radius: 18px; background: #fff; box-shadow: 0 6px 22px rgba(0,0,0,.12); text-align: center; }
        .avatar { display: grid; width: 76px; height: 76px; margin: -46px auto 12px; place-items: center; border: 4px solid #fff; border-radius: 50%; background: #fee2e2; color: #dc2626; font: 800 30px 'Baloo 2', cursive; }
        .name { font: 800 23px 'Baloo 2', cursive; }
        .phone { margin-top: 2px; color: #6b7280; font-size: 13px; font-weight: 700; }
        .balance { margin-top: 18px; padding: 13px; border-radius: 12px; background: #f0fdf4; color: #15803d; }
        .balance span { display: block; color: #6b7280; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .4px; }
        .balance strong { display: block; margin-top: 3px; font-size: 24px; }
        .details { margin: 0 16px; overflow: hidden; border-radius: 16px; background: #fff; box-shadow: 0 3px 12px rgba(0,0,0,.07); }
        .details-title { padding: 15px 16px 10px; font: 800 17px 'Baloo 2', cursive; }
        .detail { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 14px 16px; border-top: 1px solid #f0f0f0; }
        .detail-label { color: #6b7280; font-size: 12px; font-weight: 800; }
        .detail-value { text-align: right; font-size: 13px; font-weight: 800; }
        .badge { padding: 4px 9px; border-radius: 999px; background: #dcfce7; color: #15803d; font-size: 11px; text-transform: capitalize; }
        .actions { margin: 18px 16px; display: grid; gap: 10px; }
        .action { padding: 13px; border-radius: 11px; background: #e8192c; color: #fff; font: 800 14px 'Nunito', sans-serif; text-align: center; text-decoration: none; }
        .logout { border: 0; background: #fff; color: #dc2626; cursor: pointer; }
        .logout-form { display: contents; }
    </style>
</head>
<body>
    <main class="app">
        <header class="header">
            <div class="header-top">
                <a href="{{ route('game.index') }}" class="back-btn" aria-label="Back to game">‹</a>
                <div class="header-title">My Profile</div>
                <div class="header-spacer"></div>
            </div>
        </header>

        <section class="profile-card">
            <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <h1 class="name">{{ $user->name }}</h1>
            <p class="phone">+91 {{ $user->phone }}</p>
            <div class="balance">
                <span>Wallet Balance</span>
                <strong>₹{{ number_format($user->wallet->balance ?? 0, 2) }}</strong>
            </div>
        </section>

        <section class="details">
            <h2 class="details-title">Account Details</h2>
            <div class="detail"><span class="detail-label">Full name</span><span class="detail-value">{{ $user->name }}</span></div>
            <div class="detail"><span class="detail-label">Mobile number</span><span class="detail-value">+91 {{ $user->phone }}</span></div>
            <div class="detail"><span class="detail-label">Account type</span><span class="detail-value badge">{{ $user->role }}</span></div>
            <div class="detail"><span class="detail-label">Member since</span><span class="detail-value">{{ $user->created_at?->format('d M Y') }}</span></div>
        </section>

        <div class="actions">
            <a class="action" href="{{ route('wallet.index') }}">Open Wallet</a>
            <form class="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="action logout" type="submit">Log out</button>
            </form>
        </div>
    </main>
</body>
</html>
