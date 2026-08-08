<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin — Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --red: #e8192c; --green: #138808; --violet: #7c3aed;
            --orange: #f97316; --blue: #2563eb; --dark: #1a1a2e;
            --gray: #6b7280; --light: #f3f4f6; --shadow: 0 4px 16px rgba(0,0,0,0.10);
        }
        body { font-family: 'Nunito', sans-serif; background: var(--light); display: flex; justify-content: center; min-height: 100vh; }
        .app { width: 100%; max-width: 430px; background: var(--light); min-height: 100vh; padding-bottom: 80px; }

        /* Header */
        .header { background: linear-gradient(135deg, var(--dark) 0%, #2d2d44 100%); padding: 14px 16px 20px; border-radius: 0 0 22px 22px; }
        .header-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .header-title { font-family: 'Baloo 2', cursive; color: #fff; font-size: 20px; font-weight: 800; }
        .logout-btn { background: rgba(255,255,255,0.15); border: none; color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .admin-badge { background: var(--red); color: #fff; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: 800; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 16px 12px 0; }
        .stat-card { background: #fff; border-radius: 14px; padding: 14px; box-shadow: var(--shadow); }
        .stat-icon { font-size: 22px; margin-bottom: 6px; }
        .stat-value { font-size: 22px; font-weight: 900; color: #1f2937; font-family: 'Baloo 2', cursive; }
        .stat-label { font-size: 11px; font-weight: 700; color: var(--gray); margin-top: 2px; }
        .stat-card.red   .stat-value { color: var(--red); }
        .stat-card.green .stat-value { color: var(--green); }
        .stat-card.blue  .stat-value { color: var(--blue); }
        .stat-card.orange .stat-value { color: var(--orange); }

        /* Section */
        .section-title { font-size: 14px; font-weight: 800; color: #374151; padding: 16px 12px 8px; display: flex; align-items: center; justify-content: space-between; }
        .see-all { font-size: 12px; color: var(--red); text-decoration: none; font-weight: 800; }

        /* Round Card */
        .round-card { margin: 0 12px; background: linear-gradient(135deg, var(--red), #9f1239); border-radius: 16px; padding: 16px; color: #fff; }
        .round-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .round-info h3 { font-family: 'Baloo 2', cursive; font-size: 18px; font-weight: 800; }
        .round-info p { font-size: 11px; opacity: 0.8; margin-top: 2px; }
        .round-timer { text-align: right; }
        .round-timer .timer-val { font-family: 'Baloo 2', cursive; font-size: 28px; font-weight: 800; }
        .round-timer .timer-label { font-size: 10px; opacity: 0.8; }
        .round-stats { display: flex; gap: 10px; }
        .round-stat { flex: 1; background: rgba(255,255,255,0.15); border-radius: 10px; padding: 8px; text-align: center; }
        .round-stat .val { font-size: 16px; font-weight: 900; }
        .round-stat .lbl { font-size: 10px; opacity: 0.8; margin-top: 2px; }

        /* Manual Result */
        .manual-result { margin: 12px; background: #fff; border-radius: 16px; padding: 16px; box-shadow: var(--shadow); }
        .manual-title { font-size: 14px; font-weight: 800; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
        .number-grid { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; }
        .num-btn { width: 44px; height: 44px; border-radius: 50%; border: 2px solid #e5e7eb; background: #f9fafb; font-size: 16px; font-weight: 800; cursor: pointer; transition: all 0.15s; color: #374151; }
        .num-btn.selected { border-color: var(--red); background: var(--red); color: #fff; transform: scale(1.1); }
        .set-result-btn { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--dark), #2d2d44); color: #fff; border: none; border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 800; cursor: pointer; }

        /* Recent Rounds */
        .list-card { margin: 0 12px; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: var(--shadow); }
        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 11px 14px; border-bottom: 1px solid #f3f4f6; }
        .list-item:last-child { border-bottom: none; }
        .list-left { display: flex; align-items: center; gap: 10px; }
        .list-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .list-icon.green  { background: #dcfce7; }
        .list-icon.red    { background: #fee2e2; }
        .list-icon.violet { background: #ede9fe; }
        .list-title { font-size: 13px; font-weight: 800; color: #1f2937; }
        .list-sub   { font-size: 11px; color: var(--gray); font-weight: 600; margin-top: 1px; }
        .list-right { text-align: right; }
        .list-val   { font-size: 13px; font-weight: 800; color: #1f2937; }
        .list-time  { font-size: 10px; color: #9ca3af; margin-top: 2px; }

        /* Bottom Nav */
        .bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 430px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; z-index: 50; box-shadow: 0 -4px 16px rgba(0,0,0,0.08); }
        .nav-item { flex: 1; padding: 10px 6px; text-align: center; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .nav-item .nav-icon { font-size: 20px; margin-bottom: 2px; }
        .nav-item .nav-label { font-size: 10px; font-weight: 800; color: #9ca3af; }
        .nav-item.active .nav-label { color: var(--red); }

        /* Toast */
        .toast { position: fixed; top: 16px; left: 50%; transform: translateX(-50%) translateY(-80px); background: var(--dark); color: #fff; padding: 10px 20px; border-radius: 20px; font-size: 13px; font-weight: 700; z-index: 999; transition: transform 0.3s ease; white-space: nowrap; max-width: 90%; }
        .toast.show    { transform: translateX(-50%) translateY(0); }
        .toast.success { background: #16a34a; }
        .toast.error   { background: var(--red); }

        /////////////

                    /* Number buttons color mapping */
        .num-btn.violet { border-color: #7c3aed; color: #7c3aed; }
        .num-btn.green  { border-color: #138808; color: #138808; }
        .num-btn.red    { border-color: #e8192c; color: #e8192c; }

        .num-btn.violet.selected { background: #7c3aed; border-color: #7c3aed; color: #fff; }
        .num-btn.green.selected  { background: #138808; border-color: #138808; color: #fff; }
        .num-btn.red.selected    { background: #e8192c; border-color: #e8192c; color: #fff; }
    </style>
</head>
<body>
<div class="app">

    <!-- HEADER -->
    <div class="header">
        <div class="header-top">
            <div>
                <div class="header-title">Admin Panel</div>
                <span class="admin-badge">🔐 Super Admin</span>
            </div>
            <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                🚪 Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-icon">👥</div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon">🎮</div>
            <div class="stat-value">{{ $stats['total_rounds'] }}</div>
            <div class="stat-label">Total Rounds</div>
        </div>
        <div class="stat-card red">
            <div class="stat-icon">⏳</div>
            <div class="stat-value">{{ $stats['pending_deposits'] }}</div>
            <div class="stat-label">Pending Deposits</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-icon">💸</div>
            <div class="stat-value">{{ $stats['pending_withdraws'] }}</div>
            <div class="stat-label">Pending Withdrawals</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon">🎯</div>
            <div class="stat-value">{{ $stats['today_bets'] }}</div>
            <div class="stat-label">Today Bets</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon">💰</div>
            <div class="stat-value">₹{{ number_format($stats['today_revenue'], 0) }}</div>
            <div class="stat-label">Today Revenue</div>
        </div>
    </div>

    <!-- CURRENT ROUND -->
    <div class="section-title">Current Round</div>
    <div class="round-card">
        <div class="round-card-top">
            <div class="round-info">
                <h3>Round #<span id="roundId">--</span></h3>
                <p>Win Go 1Min</p>
            </div>
            <div class="round-timer">
                <div class="timer-val" id="roundTimer">--</div>
                <div class="timer-label">Seconds Left</div>
            </div>
        </div>
        <div class="round-stats">
            <div class="round-stat">
                <div class="val" id="totalBets">--</div>
                <div class="lbl">Total Bets</div>
            </div>
            <div class="round-stat">
                <div class="val" id="totalAmount">--</div>
                <div class="lbl">Total Amount</div>
            </div>
            <div class="round-stat">
                <div class="val" id="manualStatus">--</div>
                <div class="lbl">Manual</div>
            </div>
        </div>
    </div>
    <!-- LIVE BET STATS -->
<div class="section-title">Live Bet Stats</div>
<div style="margin: 0 12px;">

    <!-- Size Stats -->
    <div style="display:flex;gap:10px;margin-bottom:10px;">
        <div style="flex:1;background:#fff;border-radius:14px;padding:14px;box-shadow:var(--shadow);">
            <div style="font-size:12px;font-weight:800;color:#f97316;margin-bottom:6px;">🔴 Big</div>
            <div style="font-size:20px;font-weight:900;color:#1f2937;" id="stat-big-amount">₹0</div>
            <div style="font-size:11px;color:#9ca3af;font-weight:700;" id="stat-big-count">0 bets</div>
            <!-- Progress bar -->
            <div style="background:#f3f4f6;border-radius:4px;height:6px;margin-top:8px;">
                <div id="bar-big" style="background:#f97316;height:6px;border-radius:4px;width:0%;transition:width 0.3s;"></div>
            </div>
        </div>
        <div style="flex:1;background:#fff;border-radius:14px;padding:14px;box-shadow:var(--shadow);">
            <div style="font-size:12px;font-weight:800;color:#2563eb;margin-bottom:6px;">🔵 Small</div>
            <div style="font-size:20px;font-weight:900;color:#1f2937;" id="stat-small-amount">₹0</div>
            <div style="font-size:11px;color:#9ca3af;font-weight:700;" id="stat-small-count">0 bets</div>
            <div style="background:#f3f4f6;border-radius:4px;height:6px;margin-top:8px;">
                <div id="bar-small" style="background:#2563eb;height:6px;border-radius:4px;width:0%;transition:width 0.3s;"></div>
            </div>
        </div>
    </div>

    <!-- Color Stats -->
    <div style="display:flex;gap:10px;margin-bottom:10px;">
        <div style="flex:1;background:#fff;border-radius:14px;padding:12px;box-shadow:var(--shadow);">
            <div style="font-size:11px;font-weight:800;color:#138808;">🟢 Green</div>
            <div style="font-size:17px;font-weight:900;color:#1f2937;" id="stat-green-amount">₹0</div>
            <div style="font-size:10px;color:#9ca3af;font-weight:700;" id="stat-green-count">0 bets</div>
        </div>
        <div style="flex:1;background:#fff;border-radius:14px;padding:12px;box-shadow:var(--shadow);">
            <div style="font-size:11px;font-weight:800;color:#e8192c;">🔴 Red</div>
            <div style="font-size:17px;font-weight:900;color:#1f2937;" id="stat-red-amount">₹0</div>
            <div style="font-size:10px;color:#9ca3af;font-weight:700;" id="stat-red-count">0 bets</div>
        </div>
        <div style="flex:1;background:#fff;border-radius:14px;padding:12px;box-shadow:var(--shadow);">
            <div style="font-size:11px;font-weight:800;color:#7c3aed;">🟣 Violet</div>
            <div style="font-size:17px;font-weight:900;color:#1f2937;" id="stat-violet-amount">₹0</div>
            <div style="font-size:10px;color:#9ca3af;font-weight:700;" id="stat-violet-count">0 bets</div>
        </div>
    </div>

    <!-- Number Stats -->
    <div style="background:#fff;border-radius:14px;padding:14px;box-shadow:var(--shadow);margin-bottom:10px;">
        <div style="font-size:12px;font-weight:800;color:#374151;margin-bottom:10px;">🎯 Number Bets</div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;" id="number-stats">
            <!-- JS se fill hoga -->
        </div>
    </div>

</div>
    <!-- MANUAL RESULT -->
    <div class="manual-result">
        <div class="manual-title">🎯 Set Manual Result</div>
        <div class="number-grid">
    @php
        $colorMap = [
            0 => 'violet',
            1 => 'green',
            2 => 'red',
            3 => 'green',
            4 => 'red',
            5 => 'violet',
            6 => 'red',
            7 => 'green',
            8 => 'red',
            9 => 'green',
        ];
    @endphp

    @for($i = 0; $i <= 9; $i++)
    <button class="num-btn {{ $colorMap[$i] }}" onclick="selectNum(this, {{ $i }})">
        {{ $i }}
    </button>
    @endfor
</div>
        {{-- <div class="number-grid">
            @for($i = 0; $i <= 9; $i++)
            <button class="num-btn" onclick="selectNum(this, {{ $i }})">{{ $i }}</button>
            @endfor
        </div> --}}

        <form method="POST" action="{{ route('admin.result') }}" id="resultForm">
            @csrf
            <input type="hidden" name="manual_number" id="selectedNum" value="">
            <button type="submit" class="set-result-btn">✅ Set Result</button>
        </form>
    </div>

    <!-- RECENT ROUNDS -->
    <div class="section-title">
        Recent Rounds
        <a href="#" class="see-all">See All</a>
    </div>
    <div class="list-card">
        @forelse($recentRounds as $r)
        <div class="list-item">
            <div class="list-left">
                <div class="list-icon {{ $r->result_color ?? 'green' }}">
                    {{ $r->result_number ?? '?' }}
                </div>
                <div>
                    <div class="list-title">Round #{{ $r->id }}</div>
                    <div class="list-sub">{{ ucfirst($r->result_color ?? 'pending') }} • {{ ucfirst($r->result_size ?? '--') }}</div>
                </div>
            </div>
            <div class="list-right">
                <div class="list-val {{ $r->status === 'open' ? 'color:green' : '' }}">
                    <span style="color: {{ $r->status === 'open' ? '#16a34a' : '#9ca3af' }}">
                        {{ ucfirst($r->status) }}
                    </span>
                </div>
                <div class="list-time">{{ $r->created_at->format('h:i A') }}</div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:20px;color:#aaa;font-size:13px;">Koi rounds nahi!</div>
        @endforelse
    </div>

</div>

<!-- BOTTOM NAV -->
{{-- <div class="bottom-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item active">
        <div class="nav-icon">🏠</div>
        <div class="nav-label">Dashboard</div>
    </a>
    <a href="{{ route('admin.users') }}" class="nav-item">
        <div class="nav-icon">👥</div>
        <div class="nav-label">Users</div>
    </a>
    <a href="{{ route('admin.deposits') }}" class="nav-item">
        <div class="nav-icon">💰</div>
        <div class="nav-label">Deposits</div>
    </a>
    <a href="{{ route('admin.withdrawals') }}" class="nav-item">
        <div class="nav-icon">💸</div>
        <div class="nav-label">Withdraw</div>
    </a>
</div> --}}
<!-- BOTTOM NAV -->
    <div class="bottom-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <div class="nav-icon">🏠</div>
            <div class="nav-label">Dashboard</div>
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item">
            <div class="nav-icon">👥</div>
            <div class="nav-label">Users</div>
        </a>
        <a href="{{ route('admin.deposits') }}" class="nav-item">
            <div class="nav-icon">💰</div>
            <div class="nav-label">Deposits</div>
        </a>
        <a href="{{ route('admin.withdrawals') }}" class="nav-item">
            <div class="nav-icon">💸</div>
            <div class="nav-label">Withdraw</div>
        </a>
        <a href="{{ route('admin.queries') }}" class="nav-item">
            <div class="nav-icon">📩</div>
            <div class="nav-label">Queries</div>
        </a>
    </div>
<div class="toast" id="toast"></div>

<script>
    let selectedNumber = null;

    function selectNum(el, num) {
        document.querySelectorAll('.num-btn').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        selectedNumber = num;
        document.getElementById('selectedNum').value = num;
    }

  

    setInterval(() => {
    fetch('{{ route("admin.round") }}')
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;

            // Round info
            document.getElementById('roundId').textContent      = data.round_id ?? '--';
            document.getElementById('roundTimer').textContent   = data.seconds ?? '--';
            document.getElementById('totalBets').textContent    = data.total_bets ?? 0;
            document.getElementById('totalAmount').textContent  = '₹' + (data.total_amount ?? 0);
            document.getElementById('manualStatus').textContent = data.is_manual ? '✅ Set' : '❌ No';

            if (!data.stats) return;

            const s = data.stats;
            const totalSize = (s.big.amount + s.small.amount) || 1;

            // Big/Small
            document.getElementById('stat-big-amount').textContent   = '₹' + s.big.amount;
            document.getElementById('stat-big-count').textContent    = s.big.count + ' bets';
            document.getElementById('stat-small-amount').textContent = '₹' + s.small.amount;
            document.getElementById('stat-small-count').textContent  = s.small.count + ' bets';

            // Progress bars
            document.getElementById('bar-big').style.width   = ((s.big.amount / totalSize) * 100) + '%';
            document.getElementById('bar-small').style.width = ((s.small.amount / totalSize) * 100) + '%';

            // Colors
            document.getElementById('stat-green-amount').textContent  = '₹' + s.green.amount;
            document.getElementById('stat-green-count').textContent   = s.green.count + ' bets';
            document.getElementById('stat-red-amount').textContent    = '₹' + s.red.amount;
            document.getElementById('stat-red-count').textContent     = s.red.count + ' bets';
            document.getElementById('stat-violet-amount').textContent = '₹' + s.violet.amount;
            document.getElementById('stat-violet-count').textContent  = s.violet.count + ' bets';

            // Numbers
            const numContainer = document.getElementById('number-stats');
            numContainer.innerHTML = Object.entries(s.numbers).map(([num, val]) => `
                <div style="
                    flex:1;min-width:50px;
                    background:#f9fafb;
                    border-radius:10px;
                    padding:8px 6px;
                    text-align:center;
                    border: 2px solid ${val.amount > 0 ? '#e8192c' : '#e5e7eb'};
                ">
                    <div style="font-size:16px;font-weight:900;color:#1f2937;">${num}</div>
                    <div style="font-size:10px;font-weight:800;color:#e8192c;">₹${val.amount}</div>
                    <div style="font-size:9px;color:#9ca3af;">${val.count} bets</div>
                </div>
            `).join('');
        });
    }, 2000);

    function showToast(msg, type = '') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast show ' + type;
        setTimeout(() => t.className = 'toast', 2800);
    }

    

    @if(session('success'))
        showToast('✅ {{ session("success") }}', 'success');
    @endif
    @if(session('error'))
        showToast('❌ {{ session("error") }}', 'error');
    @endif
</script>
</body>
</html>