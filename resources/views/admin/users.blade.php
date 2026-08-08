<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin — Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --red: #e8192c; --green: #138808; --dark: #1a1a2e; --gray: #6b7280; --light: #f3f4f6; --shadow: 0 4px 16px rgba(0,0,0,0.10); }
        body { font-family: 'Nunito', sans-serif; background: var(--light); display: flex; justify-content: center; min-height: 100vh; }
        .app { width: 100%; max-width: 430px; background: var(--light); min-height: 100vh; padding-bottom: 80px; }

        .header { background: linear-gradient(135deg, var(--dark), #2d2d44); padding: 14px 16px 18px; border-radius: 0 0 22px 22px; }
        .header-top { display: flex; align-items: center; gap: 10px; }
        .back-btn { background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .header-title { font-family: 'Baloo 2', cursive; color: #fff; font-size: 20px; font-weight: 800; }

        .search-box { margin: 12px; position: relative; }
        .search-input { width: 100%; padding: 11px 14px 11px 38px; border: 2px solid #e5e7eb; border-radius: 12px; font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 700; outline: none; background: #fff; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 16px; }

        .user-list { margin: 0 12px; }
        .user-card { background: #fff; border-radius: 14px; padding: 14px; margin-bottom: 10px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 46px; height: 46px; border-radius: 14px; background: linear-gradient(135deg, var(--dark), #2d2d44); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; font-weight: 800; flex-shrink: 0; font-family: 'Baloo 2', cursive; }
        .user-info { flex: 1; }
        .user-name { font-size: 14px; font-weight: 800; color: #1f2937; }
        .user-phone { font-size: 12px; color: var(--gray); font-weight: 600; margin-top: 2px; }
        .user-balance { font-size: 12px; color: var(--green); font-weight: 800; margin-top: 2px; }
        .user-right { text-align: right; }
        .user-date { font-size: 10px; color: #9ca3af; margin-bottom: 6px; }

        .toggle-btn { padding: 6px 14px; border: none; border-radius: 20px; font-family: 'Nunito', sans-serif; font-size: 11px; font-weight: 800; cursor: pointer; }
        .toggle-btn.active { background: #fee2e2; color: var(--red); }
        .toggle-btn.banned { background: #dcfce7; color: var(--green); }

        .badge-admin  { background: #ede9fe; color: #6d28d9; padding: 2px 8px; border-radius: 8px; font-size: 10px; font-weight: 800; }
        .badge-user   { background: #dbeafe; color: #1d4ed8; padding: 2px 8px; border-radius: 8px; font-size: 10px; font-weight: 800; }
        .badge-banned { background: #fee2e2; color: var(--red); padding: 2px 8px; border-radius: 8px; font-size: 10px; font-weight: 800; }

        .pagination { display: flex; justify-content: center; gap: 6px; padding: 14px 12px; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 800; text-decoration: none; color: #555; background: #fff; border: 1.5px solid #e5e7eb; }
        .pagination .active-page { background: var(--red); color: #fff; border-color: var(--red); }

        .bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 430px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; z-index: 50; box-shadow: 0 -4px 16px rgba(0,0,0,0.08); }
        .nav-item { flex: 1; padding: 10px 6px; text-align: center; cursor: pointer; text-decoration: none; }
        .nav-item .nav-icon { font-size: 20px; margin-bottom: 2px; }
        .nav-item .nav-label { font-size: 10px; font-weight: 800; color: #9ca3af; }
        .nav-item.active .nav-label { color: var(--red); }
    </style>
</head>
<body>
<div class="app">

    <div class="header">
        <div class="header-top">
            <a class="back-btn" href="{{ route('admin.dashboard') }}">&#8249;</a>
            <div class="header-title">👥 Users ({{ $users->total() }})</div>
        </div>
    </div>

    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" class="search-input" placeholder="Name ya phone search karo..." oninput="filterUsers(this.value)">
    </div>

    <div class="user-list" id="userList">
        @forelse($users as $user)
        <div class="user-card" data-name="{{ strtolower($user->name) }}" data-phone="{{ $user->phone }}">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-phone">📱 {{ $user->phone }}</div>
                <div class="user-balance">💰 ₹{{ number_format($user->wallet->balance ?? 0, 2) }}</div>
            </div>
            <div class="user-right">
                <div class="user-date">{{ $user->created_at->format('d M Y') }}</div>
                <span class="badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                <br><br>
                @if($user->role !== 'admin')
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf
                    <button type="submit" class="toggle-btn {{ $user->role === 'banned' ? 'banned' : 'active' }}">
                        {{ $user->role === 'banned' ? '✅ Unblock' : '🚫 Block' }}
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:30px;color:#aaa;font-size:13px;font-weight:700;">Koi user nahi hai!</div>
        @endforelse
    </div>

    @if($users->hasPages())
    <div class="pagination">
        @if($users->onFirstPage())
            <span>← Prev</span>
        @else
            <a href="{{ $users->previousPageUrl() }}">← Prev</a>
        @endif
        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if($page == $users->currentPage())
                <span class="active-page">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach
        @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}">Next →</a>
        @else
            <span>Next →</span>
        @endif
    </div>
    @endif

</div>

<div class="bottom-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <div class="nav-icon">🏠</div><div class="nav-label">Dashboard</div>
    </a>
    <a href="{{ route('admin.users') }}" class="nav-item active">
        <div class="nav-icon">👥</div><div class="nav-label">Users</div>
    </a>
    <a href="{{ route('admin.deposits') }}" class="nav-item">
        <div class="nav-icon">💰</div><div class="nav-label">Deposits</div>
    </a>
    <a href="{{ route('admin.withdrawals') }}" class="nav-item">
        <div class="nav-icon">💸</div><div class="nav-label">Withdraw</div>
    </a>
        <a href="{{ route('admin.queries') }}" class="nav-item">
        <div class="nav-icon">📩</div>
        <div class="nav-label">Queries</div>
    </a>
</div>

<script>
    function filterUsers(val) {
        val = val.toLowerCase();
        document.querySelectorAll('.user-card').forEach(card => {
            const name  = card.dataset.name;
            const phone = card.dataset.phone;
            card.style.display = (name.includes(val) || phone.includes(val)) ? 'flex' : 'none';
        });
    }
</script>
</body>
</html>