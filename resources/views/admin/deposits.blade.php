<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin — Deposits</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --red: #e8192c; --green: #138808; --dark: #1a1a2e; --gray: #6b7280; --light: #f3f4f6; --shadow: 0 4px 16px rgba(0,0,0,0.10); }
        body { font-family: 'Nunito', sans-serif; background: var(--light); display: flex; justify-content: center; min-height: 100vh; }
        .app { width: 100%; max-width: 430px; min-height: 100vh; padding-bottom: 80px; }

        .header { background: linear-gradient(135deg, var(--green), #0d6b06); padding: 14px 16px 18px; border-radius: 0 0 22px 22px; }
        .header-top { display: flex; align-items: center; gap: 10px; }
        .back-btn { background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .header-title { font-family: 'Baloo 2', cursive; color: #fff; font-size: 20px; font-weight: 800; }

        .section-title { font-size: 13px; font-weight: 800; color: #6b7280; padding: 14px 12px 8px; text-transform: uppercase; letter-spacing: 0.5px; }

        .deposit-list { margin: 0 12px; }
        .deposit-card { background: #fff; border-radius: 14px; padding: 14px; margin-bottom: 10px; box-shadow: var(--shadow); }
        .deposit-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .deposit-user { display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--green), #0d6b06); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; font-weight: 800; font-family: 'Baloo 2', cursive; }
        .user-name  { font-size: 13px; font-weight: 800; color: #1f2937; }
        .user-phone { font-size: 11px; color: var(--gray); font-weight: 600; }
        .deposit-amount { font-size: 20px; font-weight: 900; color: var(--green); font-family: 'Baloo 2', cursive; }

        .deposit-info { background: #f9fafb; border-radius: 10px; padding: 10px 12px; margin-bottom: 10px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { font-size: 11px; color: var(--gray); font-weight: 700; }
        .info-value { font-size: 12px; font-weight: 800; color: #1f2937; }
        .utr-val { color: var(--green); font-family: 'Baloo 2', cursive; font-size: 13px; }

        .action-btns { display: flex; gap: 8px; }
        .approve-btn { flex: 1; padding: 10px; background: linear-gradient(135deg, var(--green), #0d6b06); color: #fff; border: none; border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800; cursor: pointer; }
        .reject-btn  { flex: 1; padding: 10px; background: linear-gradient(135deg, var(--red), #b91c1c); color: #fff; border: none; border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800; cursor: pointer; }

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
        .toast.error   { background: var(--red); }
    </style>
</head>
<body>
<div class="app">

    <div class="header">
        <div class="header-top">
            <a class="back-btn" href="{{ route('admin.dashboard') }}">&#8249;</a>
            <div class="header-title">💰 Pending Deposits</div>
        </div>
    </div>

    <div class="section-title">{{ $deposits->total() }} Requests Pending</div>

    <div class="deposit-list">
        @forelse($deposits as $deposit)
        <div class="deposit-card">
            <div class="deposit-top">
                <div class="deposit-user">
                    <div class="user-avatar">{{ strtoupper(substr($deposit->user->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-name">{{ $deposit->user->name }}</div>
                        <div class="user-phone">📱 {{ $deposit->user->phone }}</div>
                    </div>
                </div>
                <div class="deposit-amount">₹{{ number_format($deposit->amount, 2) }}</div>
            </div>

            <div class="deposit-info">
                <div class="info-row">
                    <span class="info-label">UTR Number</span>
                    <span class="info-value utr-val">{{ $deposit->utr_number ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Requested At</span>
                    <span class="info-value">{{ $deposit->created_at->format('d M, h:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Current Balance</span>
                    <span class="info-value">₹{{ number_format($deposit->user->wallet->balance ?? 0, 2) }}</span>
                </div>
            </div>

            <div class="action-btns">
                <form method="POST" action="{{ route('admin.deposits.approve', $deposit) }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="approve-btn" style="width:100%;">✅ Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.deposits.reject', $deposit) }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="reject-btn" style="width:100%;" onclick="return confirm('Reject karna chahte ho?')">❌ Reject</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-msg">🎉 Koi pending deposit nahi hai!</div>
        @endforelse
    </div>

    @if($deposits->hasPages())
    <div class="pagination">
        @if($deposits->onFirstPage()) <span>← Prev</span>
        @else <a href="{{ $deposits->previousPageUrl() }}">← Prev</a> @endif
        @foreach($deposits->getUrlRange(1, $deposits->lastPage()) as $page => $url)
            @if($page == $deposits->currentPage()) <span class="active-page">{{ $page }}</span>
            @else <a href="{{ $url }}">{{ $page }}</a> @endif
        @endforeach
        @if($deposits->hasMorePages()) <a href="{{ $deposits->nextPageUrl() }}">Next →</a>
        @else <span>Next →</span> @endif
    </div>
    @endif

</div>

<div class="bottom-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><div class="nav-icon">🏠</div><div class="nav-label">Dashboard</div></a>
    <a href="{{ route('admin.users') }}" class="nav-item"><div class="nav-icon">👥</div><div class="nav-label">Users</div></a>
    <a href="{{ route('admin.deposits') }}" class="nav-item active"><div class="nav-icon">💰</div><div class="nav-label">Deposits</div></a>
    
    <a href="{{ route('admin.withdrawals') }}" class="nav-item"><div class="nav-icon">💸</div><div class="nav-label">Withdraw</div></a>
    <a href="{{ route('admin.queries') }}" class="nav-item">
    <div class="nav-icon">📩</div>
    <div class="nav-label">Queries</div>
</a>
</div>

<div class="toast" id="toast"></div>
<script>
    function showToast(msg, type='') { const t=document.getElementById('toast'); t.textContent=msg; t.className='toast show '+type; setTimeout(()=>t.className='toast',2800); }
    @if(session('success')) showToast('✅ {{ session("success") }}','success'); @endif
    @if(session('error'))   showToast('❌ {{ session("error") }}','error'); @endif
</script>
</body>
</html>