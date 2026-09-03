<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lottery777 — Wallet</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        :root {
            --red:    #e8192c;
            --green:  #138808;
            --violet: #7c3aed;
            --orange: #f97316;
            --blue:   #2563eb;
            --dark:   #1a1a2e;
            --gray:   #6b7280;
            --light:  #f3f4f6;
            --white:  #ffffff;
            --shadow: 0 4px 16px rgba(0,0,0,0.10);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--light);
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .app {
            width: 100%;
            max-width: 430px;
            background: var(--light);
            min-height: 100vh;
            padding-bottom: 30px;
        }

        /* ── Header ── */
        .header {
            background: linear-gradient(135deg, var(--red) 0%, #b91c1c 100%);
            padding: 14px 16px 24px;
            border-radius: 0 0 24px 24px;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .back-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: #fff;
            width: 32px; height: 32px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
        }

        .header-title {
            font-family: 'Baloo 2', cursive;
            color: #fff;
            font-size: 20px;
            font-weight: 800;
        }

        .header-right { width: 32px; }

        .balance-card {
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            padding: 16px;
            text-align: center;
            border: 1.5px solid rgba(255,255,255,0.25);
        }

        .balance-label {
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .balance-amount {
            color: #fff;
            font-size: 32px;
            font-weight: 900;
            font-family: 'Baloo 2', cursive;
        }

        .balance-sub {
            color: rgba(255,255,255,0.7);
            font-size: 11px;
            margin-top: 2px;
        }

        /* ── Action Buttons ── */
        .action-btns {
            display: flex;
            gap: 12px;
            padding: 16px 12px 0;
        }

        .action-btn {
            flex: 1;
            background: #fff;
            border: none;
            border-radius: 14px;
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: transform 0.15s;
        }

        .action-btn:active { transform: scale(0.96); }

        .action-btn .btn-icon {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .action-btn .btn-label {
            font-size: 13px;
            font-weight: 800;
            color: #374151;
        }

        .action-btn.deposit .btn-label { color: var(--green); }
        .action-btn.withdraw .btn-label { color: var(--red); }

        /* ── Section Title ── */
        .section-title {
            font-size: 14px;
            font-weight: 800;
            color: #374151;
            padding: 16px 12px 8px;
        }

        /* ── Transaction List ── */
        .transaction-list {
            margin: 0 12px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .transaction-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s;
        }

        .transaction-item:last-child { border-bottom: none; }
        .transaction-item:hover { background: #fafafa; }

        .tx-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .tx-icon.deposit  { background: #dcfce7; }
        .tx-icon.withdraw { background: #fee2e2; }
        .tx-icon.bet      { background: #ede9fe; }
        .tx-icon.winning  { background: #fef9c3; }

        .tx-info { flex: 1; }

        .tx-type {
            font-size: 13px;
            font-weight: 800;
            color: #1f2937;
            text-transform: capitalize;
        }

        .tx-desc {
            font-size: 11px;
            color: var(--gray);
            font-weight: 600;
            margin-top: 1px;
        }

        .tx-right { text-align: right; }

        .tx-amount {
            font-size: 14px;
            font-weight: 900;
        }

        .tx-amount.plus  { color: var(--green); }
        .tx-amount.minus { color: var(--red); }

        .tx-status {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 3px;
            display: inline-block;
        }

        .status-pending  { background: #fef3c7; color: #d97706; }
        .status-approved { background: #dcfce7; color: #16a34a; }
        .status-rejected { background: #fee2e2; color: var(--red); }

        .tx-date {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .empty-msg {
            text-align: center;
            padding: 30px;
            color: #aaa;
            font-size: 13px;
            font-weight: 700;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 14px 12px;
        }

        .pagination a, .pagination span {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            color: #555;
            background: #fff;
            border: 1.5px solid #e5e7eb;
        }

        .pagination .active-page {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 100;
            align-items: flex-end;
            justify-content: center;
        }

        .modal-overlay.show { display: flex; }

        .modal {
            background: #fff;
            width: 100%;
            max-width: 430px;
            border-radius: 22px 22px 0 0;
            padding: 22px 20px 30px;
            animation: slideUp 0.28s ease;
            position: relative;
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to   { transform: translateY(0); }
        }

        .modal-close {
            position: absolute;
            top: 14px; right: 16px;
            background: #f3f4f6;
            border: none;
            width: 28px; height: 28px;
            border-radius: 50%;
            font-size: 14px;
            cursor: pointer;
        }

        .modal-title {
            font-family: 'Baloo 2', cursive;
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 16px;
            color: #1f2937;
        }

        /* QR Code Box */
        .qr-box {
            background: #f9fafb;
            border-radius: 14px;
            padding: 16px;
            text-align: center;
            margin-bottom: 16px;
            border: 2px dashed #e5e7eb;
        }

        .qr-box img {
            width: 160px; height: 160px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .qr-upi {
            font-size: 13px;
            font-weight: 800;
            color: #374151;
        }

        .qr-upi span {
            color: var(--red);
            font-size: 14px;
        }

        .copy-btn {
            background: #f3f4f6;
            border: none;
            padding: 5px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 6px;
            color: #555;
        }

        .copy-btn:hover { background: #e5e7eb; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 700;
            outline: none;
            margin-bottom: 12px;
            transition: border-color 0.2s;
            color: #1f2937;
        }

        .form-input:focus { border-color: var(--red); }

        .quick-amounts {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .quick-amt {
            padding: 6px 12px;
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            color: #555;
            transition: all 0.15s;
        }

        .quick-amt:hover { border-color: var(--red); color: var(--red); }

        .submit-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            cursor: pointer;
            transition: transform 0.15s;
        }

        .submit-btn:active { transform: scale(0.97); }
        .submit-btn.green  { background: linear-gradient(135deg, #16a34a, #15803d); box-shadow: 0 4px 12px rgba(22,163,74,0.3); }
        .submit-btn.red    { background: linear-gradient(135deg, var(--red), #b91c1c); box-shadow: 0 4px 12px rgba(232,25,44,0.3); }

        .note-box {
            background: #fef9c3;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            color: #854d0e;
            margin-bottom: 14px;
            line-height: 1.5;
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%) translateY(-80px);
            background: var(--dark);
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            z-index: 999;
            transition: transform 0.3s ease;
            white-space: nowrap;
            max-width: 90%;
        }

        .toast.show    { transform: translateX(-50%) translateY(0); }
        .toast.success { background: #16a34a; }
        .toast.error   { background: var(--red); }
    </style>
</head>
<body>
<div class="app">

    <!-- HEADER -->
    <div class="header">
        <div class="header-top">
            <a class="back-btn" href="{{ route('game.index') }}">&#8249;</a>
            <div class="header-title">My Wallet</div>
            <a class="header-right" href="{{ route('profile.show') }}" style="color:#fff;text-decoration:none;font-size:12px;font-weight:800;display:flex;align-items:center;justify-content:flex-end;">Profile</a>
        </div>
        <div class="balance-card">
            <div class="balance-label">💳 Total Balance</div>
            <div class="balance-amount">₹{{ number_format($wallet->balance, 2) }}</div>
            <div class="balance-sub">{{ auth()->user()->name }}</div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-btns">
        <button class="action-btn deposit" onclick="openDeposit()">
            <div class="btn-icon">⬇️</div>
            <div class="btn-label">Deposit</div>
        </button>
        <button class="action-btn withdraw" onclick="openWithdraw()">
            <div class="btn-icon">⬆️</div>
            <div class="btn-label">Withdraw</div>
        </button>
    </div>

    <!-- TRANSACTIONS -->
    <div class="section-title">Transaction History</div>

    <div class="transaction-list">
        @forelse($transactions as $tx)
        <div class="transaction-item">
            <div class="tx-icon {{ $tx->type }}">
                @if($tx->type === 'deposit')  💰
                @elseif($tx->type === 'withdraw') 💸
                @elseif($tx->type === 'bet')   🎯
                @else 🏆
                @endif
            </div>
            <div class="tx-info">
                <div class="tx-type">{{ ucfirst($tx->type) }}</div>
                <div class="tx-desc">{{ $tx->description ?? '—' }}</div>
                <div class="tx-date">{{ $tx->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <div class="tx-right">
                <div class="tx-amount {{ in_array($tx->type, ['deposit','winning']) ? 'plus' : 'minus' }}">
                    {{ in_array($tx->type, ['deposit','winning']) ? '+' : '-' }}₹{{ number_format($tx->type === 'deposit' ? $tx->amount + $tx->bonus_amount : $tx->amount, 2) }}
                </div>
                <span class="tx-status status-{{ $tx->status }}">
                    {{ ucfirst($tx->status) }}
                </span>
            </div>
        </div>
        @empty
        <div class="empty-msg">Koi transaction nahi hai abhi!</div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($transactions->hasPages())
    <div class="pagination">
        @if($transactions->onFirstPage())
            <span>← Prev</span>
        @else
            <a href="{{ $transactions->previousPageUrl() }}">← Prev</a>
        @endif

        @foreach($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
            @if($page == $transactions->currentPage())
                <span class="active-page">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if($transactions->hasMorePages())
            <a href="{{ $transactions->nextPageUrl() }}">Next →</a>
        @else
            <span>Next →</span>
        @endif
    </div>
    @endif

</div><!-- end .app -->

<!-- DEPOSIT MODAL -->
<div class="modal-overlay" id="depositModal" onclick="closeOutside(event, 'depositModal')">
    <div class="modal">
        <button class="modal-close" onclick="closeModal('depositModal')">✕</button>
        <div class="modal-title">💰 Deposit </div>

        <!-- QR Code -->
        <div class="qr-box">
            <img src="{{ $paymentQrUrl }}" alt="QR Code">
            <div class="qr-upi">UPI ID: <span id="upiId">{{ $paymentSettings->get('payment_upi_id', 'prakasao482@ptaxis') }}</span></div>
            <button class="copy-btn" onclick="copyUPI()">📋 Copy UPI ID</button>
        </div>

        <div class="note-box">
            ⚠️ Payment karne ke baad UTR number zaroor daalo — bina UTR ke deposit approve nahi hoga!
        </div>

        <form method="POST" action="{{ route('wallet.deposit') }}">
            @csrf
            <label class="form-label">Amount (Min ₹100)</label>
            <input type="number" name="amount" class="form-input" placeholder="Amount daalo" min="100" required>

            <div class="quick-amounts">
                <button type="button" class="quick-amt" onclick="setDepAmt(100)">₹100</button>
                <button type="button" class="quick-amt" onclick="setDepAmt(500)">₹500</button>
                <button type="button" class="quick-amt" onclick="setDepAmt(1000)">₹1000</button>
                <button type="button" class="quick-amt" onclick="setDepAmt(5000)">₹5000</button>
            </div>

            <label class="form-label">UTR / Reference Number</label>
            <input type="text" name="utr_number" class="form-input" placeholder="UTR / Reference Number " required>

            <label class="form-label">Coupon code (optional)</label>
            <input type="text" name="coupon_code" class="form-input" placeholder="Enter coupon code">

            <button type="submit" class="submit-btn green">✅ Submit Request</button>
        </form>
    </div>
</div>

<!-- WITHDRAW MODAL -->
<div class="modal-overlay" id="withdrawModal" onclick="closeOutside(event, 'withdrawModal')">
    <div class="modal">
        <button class="modal-close" onclick="closeModal('withdrawModal')">✕</button>
        <div class="modal-title">💸 Withdraw </div>

        <div class="note-box">
            ⚠️ Withdrawal request approve with in 24hr!
        </div>

        <div style="background:#f0fdf4;border-radius:10px;padding:12px 14px;margin-bottom:14px;">
            <div style="font-size:12px;font-weight:700;color:#6b7280;">Available Balance</div>
            <div style="font-size:22px;font-weight:900;color:#16a34a;">₹{{ number_format($wallet->balance, 2) }}</div>
        </div>

        <form method="POST" action="{{ route('wallet.withdraw') }}">
            @csrf
            <label class="form-label">Withdraw Amount (Min ₹100)</label>
            <input type="number" name="amount" class="form-input" placeholder="Amount daalo" min="100" max="{{ $wallet->balance }}" required>

            <div class="quick-amounts">
                <button type="button" class="quick-amt" onclick="setWitAmt(100)">₹100</button>
                <button type="button" class="quick-amt" onclick="setWitAmt(500)">₹500</button>
                <button type="button" class="quick-amt" onclick="setWitAmt(1000)">₹1000</button>
                <button type="button" class="quick-amt" onclick="setWitAmt({{ (int)$wallet->balance }})">All</button>
            </div>

            <label class="form-label">UPI ID (jahan paisa chahiye)</label>
            <input type="text" name="upi_id" class="form-input" placeholder="Apna UPI ID daalo" required>

            <button type="submit" class="submit-btn red">📤 Withdraw Request</button>
        </form>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
    function openDeposit() {
        document.getElementById('depositModal').classList.add('show');
    }

    function openWithdraw() {
        document.getElementById('withdrawModal').classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function closeOutside(e, id) {
        if (e.target === document.getElementById(id)) closeModal(id);
    }

    function setDepAmt(a) {
        document.querySelector('#depositModal input[name="amount"]').value = a;
    }

    function setWitAmt(a) {
        document.querySelector('#withdrawModal input[name="amount"]').value = a;
    }

    function copyUPI() {
        const upi = document.getElementById('upiId').textContent;
        navigator.clipboard.writeText(upi).then(() => showToast('✅ UPI ID copied!', 'success'));
    }

    function showToast(msg, type = '') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className   = 'toast show ' + type;
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
