<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin — Queries</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --red: #e8192c; --green: #138808; --dark: #1a1a2e; --gray: #6b7280; --light: #f3f4f6; --shadow: 0 4px 16px rgba(0,0,0,0.10); }
        body { font-family: 'Nunito', sans-serif; background: var(--light); display: flex; justify-content: center; min-height: 100vh; }
        .app { width: 100%; max-width: 430px; min-height: 100vh; padding-bottom: 80px; }

        .header { background: linear-gradient(135deg, var(--dark), #2d2d44); padding: 14px 16px 18px; border-radius: 0 0 22px 22px; }
        .header-top { display: flex; align-items: center; gap: 10px; }
        .back-btn { background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .header-title { font-family: 'Baloo 2', cursive; color: #fff; font-size: 20px; font-weight: 800; }

        .section-title { font-size: 13px; font-weight: 800; color: #6b7280; padding: 14px 12px 8px; text-transform: uppercase; letter-spacing: 0.5px; }

        .query-list { margin: 0 12px; }

        .query-card { background: #fff; border-radius: 14px; padding: 14px; margin-bottom: 10px; box-shadow: var(--shadow); }

        .query-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--dark), #2d2d44); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; font-weight: 800; font-family: 'Baloo 2', cursive; flex-shrink: 0; }
        .user-name  { font-size: 13px; font-weight: 800; color: #1f2937; }
        .user-email { font-size: 11px; color: var(--gray); font-weight: 600; margin-top: 1px; }
        .query-date { font-size: 10px; color: #9ca3af; font-weight: 700; }

        .query-message {
            background: #f9fafb;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 800;
        }

        .status-pending { background: #fef3c7; color: #d97706; }
        .status-replied { background: #dcfce7; color: #16a34a; }

        .reply-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, var(--dark), #2d2d44);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }

        .empty-msg { text-align: center; padding: 40px; color: #aaa; font-size: 14px; font-weight: 700; }

        .pagination { display: flex; justify-content: center; gap: 6px; padding: 14px; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 800; text-decoration: none; color: #555; background: #fff; border: 1.5px solid #e5e7eb; }
        .pagination .active-page { background: var(--red); color: #fff; border-color: var(--red); }

        .bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 430px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; z-index: 50; box-shadow: 0 -4px 16px rgba(0,0,0,0.08); }
        .nav-item { flex: 1; padding: 10px 6px; text-align: center; text-decoration: none; }
        .nav-item .nav-icon { font-size: 20px; margin-bottom: 2px; }
        .nav-item .nav-label { font-size: 10px; font-weight: 800; color: #9ca3af; }
        .nav-item.active .nav-label { color: var(--red); }

        .toast { position: fixed; top: 16px; left: 50%; transform: translateX(-50%) translateY(-80px); background: var(--dark); color: #fff; padding: 10px 20px; border-radius: 20px; font-size: 13px; font-weight: 700; z-index: 999; transition: transform 0.3s; white-space: nowrap; max-width: 90%; }
        .toast.show { transform: translateX(-50%) translateY(0); }
        .toast.success { background: #16a34a; }
    </style>
</head>
<body>
<div class="app">

    <div class="header">
        <div class="header-top">
            <a class="back-btn" href="{{ route('admin.dashboard') }}">&#8249;</a>
            <div class="header-title">📩 User Queries ({{ $queries->total() }})</div>
        </div>
    </div>

    <div class="section-title">All Queries</div>

    <div class="query-list">
        @forelse($queries as $query)
        <div class="query-card">
            <div class="query-top">
                <div class="user-info">
                    <div class="user-avatar">{{ strtoupper(substr($query->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-name">{{ $query->name }}</div>
                        <div class="user-email">📧 {{ $query->email }}</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <div class="query-date">{{ $query->created_at->format('d M, h:i A') }}</div>
                    <span class="status-badge status-{{ $query->status }}">
                        {{ $query->status === 'replied' ? '✅ Replied' : '⏳ Pending' }}
                    </span>
                </div>
            </div>

            <div class="query-message">
                "{{ $query->message }}"
            </div>

            <!-- Reply via Email -->
            <a href="mailto:{{ $query->email }}?subject=Re: Your Query on Lottery777&body=Dear {{ $query->name }},%0D%0A%0D%0AThank you for contacting Lottery777 Support.%0D%0A%0D%0ARegarding your query: {{ urlencode($query->message) }}%0D%0A%0D%0A[Your Reply Here]%0D%0A%0D%0ABest Regards,%0D%0ALottery777 Support Team"
               class="reply-btn"
               onclick="markReplied({{ $query->id }})">
                📧 Reply via Email
            </a>
        </div>
        @empty
        <div class="empty-msg">🎉 No queries yet!</div>
        @endforelse
    </div>

    @if($queries->hasPages())
    <div class="pagination">
        @if($queries->onFirstPage()) <span>← Prev</span>
        @else <a href="{{ $queries->previousPageUrl() }}">← Prev</a> @endif
        @foreach($queries->getUrlRange(1, $queries->lastPage()) as $page => $url)
            @if($page == $queries->currentPage()) <span class="active-page">{{ $page }}</span>
            @else <a href="{{ $url }}">{{ $page }}</a> @endif
        @endforeach
        @if($queries->hasMorePages()) <a href="{{ $queries->nextPageUrl() }}">Next →</a>
        @else <span>Next →</span> @endif
    </div>
    @endif

</div>

<div class="bottom-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><div class="nav-icon">🏠</div><div class="nav-label">Dashboard</div></a>
    <a href="{{ route('admin.users') }}" class="nav-item"><div class="nav-icon">👥</div><div class="nav-label">Users</div></a>
    <a href="{{ route('admin.deposits') }}" class="nav-item"><div class="nav-icon">💰</div><div class="nav-label">Deposits</div></a>
    <a href="{{ route('admin.withdrawals') }}" class="nav-item"><div class="nav-icon">💸</div><div class="nav-label">Withdraw</div></a>
</div>

<div class="toast" id="toast"></div>

<script>
    function markReplied(id) {
        fetch(`/admin/queries/${id}/replied`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
            }
        });
    }

    function showToast(msg, type='') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast show ' + type;
        setTimeout(() => t.className = 'toast', 2800);
    }

    @if(session('success'))
        showToast('✅ {{ session("success") }}', 'success');
    @endif
</script>
</body>
</html>