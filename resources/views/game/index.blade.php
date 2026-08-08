<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lottery777 — Win Go</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    
</head>
<body>
<div class="app">

    <!-- HEADER -->
    <div class="header">
        <div class="header-top">
    <button class="back-btn">&#8249;</button>
    <div class="header-title">Lottery777</div>
            <div style="display:flex;align-items:center;gap:6px;">
                <a href="{{ route('help.index') }}" class="help-btn">Help</a>
                <button class="help-btn" onclick="document.getElementById('logout-form').submit()">Log out</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>
        <div class="balance-section">
            <div class="balance-amount">
                ₹<span id="walletBalance">{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</span>
                <button class="refresh-btn" onclick="refreshBalance()">↻</button>
            </div>
            <div class="balance-label">💳 Wallet Balance</div>
        </div>
        <div class="header-btns">
            <button class="btn-withdraw" onclick="window.location.href='{{ route('wallet.index') }}'">Withdraw</button>
            <button class="btn-deposit"  onclick="window.location.href='{{ route('wallet.index') }}'">Deposit</button>
        </div>
    </div>

<!-- HELP MODAL -->


    <!-- Game Warning -->
        <div style="
            margin: 10px 12px 0;
            background: #fff7ed;
            border: 1.5px solid #fed7aa;
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        ">
            <span style="font-size:16px;flex-shrink:0;">⚠️</span>
            <p style="font-size:11px;font-weight:700;color:#9a3412;line-height:1.6;margin:0;">
                यह गेम पूर्णतः जोखिम आधारित है। इसमें धन हानि की संभावना हो सकती है, इसलिए कृपया अपनी जिम्मेदारी से खेलें।
            </p>
        </div>
    <!-- GAME CARD -->
    <div class="game-card">
        <div class="game-card-inner">
            <div class="game-left">
                <span class="how-to-play">❓ How to play</span>
                <div style="font-size:11px;opacity:0.8;margin-bottom:6px;">Recent Results</div>
                <div class="recent-results" id="recentResults">
                    @foreach($recentRounds->take(6) as $r)
                        <div class="result-ball ball-{{ $r->result_color }}">{{ $r->result_number }}</div>
                    @endforeach
                </div>
            </div>
            <div class="timer-section">
                <div class="timer-label">Time Remaining</div>
                <div class="timer-digits">
                    <div class="t-digit" id="t-m1">0</div>
                    <div class="t-digit" id="t-m2">0</div>
                    <div class="t-colon">:</div>
                    <div class="t-digit" id="t-s1">0</div>  
                    <div class="t-digit" id="t-s2">0</div>
                </div>
                <div class="period-num" id="periodId">{{ $round->id }}</div>
            </div>
        </div>
        <div class="lock-banner" id="lockBanner">🔒 Betting Locked! Waite For Next </div>
    </div>

    <!-- COLOUR BUTTONS -->
    <div class="colour-btns">
        <button class="colour-btn btn-green"  onclick="openModal('color','green','Green')">Green</button>
        <button class="colour-btn btn-violet" onclick="openModal('color','violet','Violet')">Violet</button>
        <button class="colour-btn btn-red"    onclick="openModal('color','red','Red')">Red</button>
    </div>

    <!-- NUMBER BALLS -->
    <div class="number-grid">
        <div class="num-ball num-violet" onclick="openModal('number','0','Number 0')">0</div>
        <div class="num-ball num-green"  onclick="openModal('number','1','Number 1')">1</div>
        <div class="num-ball num-red"    onclick="openModal('number','2','Number 2')">2</div>
        <div class="num-ball num-green"  onclick="openModal('number','3','Number 3')">3</div>
        <div class="num-ball num-red"    onclick="openModal('number','4','Number 4')">4</div>
        <div class="num-ball num-violet" onclick="openModal('number','5','Number 5')">5</div>
        <div class="num-ball num-red"    onclick="openModal('number','6','Number 6')">6</div>
        <div class="num-ball num-green"  onclick="openModal('number','7','Number 7')">7</div>
        <div class="num-ball num-red"    onclick="openModal('number','8','Number 8')">8</div>
        <div class="num-ball num-green"  onclick="openModal('number','9','Number 9')">9</div>
    </div>

    <!-- MULTIPLIER -->
    <div class="multiplier-row">
        <button class="mult-btn active" onclick="selectMult(this, 1)">X1</button>
        <button class="mult-btn" onclick="selectMult(this, 5)">X5</button>
        <button class="mult-btn" onclick="selectMult(this, 10)">X10</button>
        <button class="mult-btn" onclick="selectMult(this, 20)">X20</button>
        <button class="mult-btn" onclick="selectMult(this, 50)">X50</button>
        <button class="mult-btn" onclick="selectMult(this, 100)">X100</button>
    </div>

    <!-- BIG / SMALL -->
    <div class="bigsmall-row">
        <button class="bs-btn btn-big"   onclick="openModal('size','big','Big')">Big</button>
        <button class="bs-btn btn-small" onclick="openModal('size','small','Small')">Small</button>
    </div>

    <!-- HISTORY TABS -->
    <div class="history-tabs">
        <div class="history-tab active" onclick="switchTab(this,'game-history')">Game History</div>
        <div class="history-tab"        onclick="switchTab(this,'my-history')">My History</div>
    </div>

    <!-- GAME HISTORY -->
    <div class="history-table" id="game-history">
        <div class="table-head">
            <span>Period</span>
            <span>No.</span>
            <span>Big/Small</span>
            <span>Color</span>
        </div>
        
        <div id="game-history-body">
    @forelse($recentRounds as $r)
    <div class="table-row">
        <span class="period-id">{{ $r->id }}</span>
        <span>{{ $r->result_number }}</span>
        <span>{{ ucfirst($r->result_size) }}</span>
        <span><span class="color-dot dot-{{ $r->result_color }}"></span></span>
    </div>
    @empty
    <div class="empty-msg">No history!</div>
    @endforelse
</div>

<!-- Pagination -->
@if($recentRounds->hasPages())
<div style="display:flex;justify-content:center;gap:6px;padding:12px;">
    {{-- Prev --}}
    @if($recentRounds->onFirstPage())
        <span style="padding:6px 12px;border-radius:8px;background:#f3f4f6;color:#9ca3af;font-size:12px;font-weight:800;">← Prev</span>
    @else
        <a href="{{ $recentRounds->previousPageUrl() }}" style="padding:6px 12px;border-radius:8px;background:#fff;border:1.5px solid #e5e7eb;color:#555;font-size:12px;font-weight:800;text-decoration:none;">← Prev</a>
    @endif

    {{-- Page Numbers --}}
    @foreach($recentRounds->getUrlRange(1, $recentRounds->lastPage()) as $page => $url)
        @if($page == $recentRounds->currentPage())
            <span style="padding:6px 12px;border-radius:8px;background:#e8192c;color:#fff;font-size:12px;font-weight:800;">{{ $page }}</span>
        @else
            <a href="{{ $url }}" style="padding:6px 12px;border-radius:8px;background:#fff;border:1.5px solid #e5e7eb;color:#555;font-size:12px;font-weight:800;text-decoration:none;">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Next --}}
    @if($recentRounds->hasMorePages())
        <a href="{{ $recentRounds->nextPageUrl() }}" style="padding:6px 12px;border-radius:8px;background:#fff;border:1.5px solid #e5e7eb;color:#555;font-size:12px;font-weight:800;text-decoration:none;">Next →</a>
    @else
        <span style="padding:6px 12px;border-radius:8px;background:#f3f4f6;color:#9ca3af;font-size:12px;font-weight:800;">Next →</span>
    @endif
</div>
@endif
    </div>

    <!-- MY HISTORY -->
    <div class="history-table" id="my-history" style="display:none;">
        <div class="my-table-head">
            <span>Period</span>
            <span>Bet</span>
            <span>Amount</span>
            <span>Result</span>
        </div>
        <div id="my-history-body">
            <div class="empty-msg">Loading...</div>
        </div>
    </div>

</div><!-- end .app -->

<!-- RESULT POPUP -->
<div class="result-overlay" id="resultOverlay">
    <div class="result-box" id="resultBox">
        <div class="result-emoji"  id="resultEmoji"></div>
        <div class="result-title"  id="resultTitle"></div>
        <div class="result-inner-box" id="resultInnerBox">
            <div class="result-number" id="resultNumber"></div>
            <div class="result-amount" id="resultAmount"></div>
        </div>
        <div class="result-balance-box">
            <span>New Balance</span>
            <span class="result-balance-val">₹<span id="resultBalance"></span></span>
        </div>
        <button class="result-close-btn" id="resultCloseBtn" onclick="closeResultPopup()">
            Continue →
        </button>
    </div>
</div>

<!-- BET MODAL -->
<div class="modal-overlay" id="betModal" onclick="closeOutside(event)">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <div class="modal-badge" id="modalBadge">Green</div>
        <div class="modal-balance">
            <span>Balance</span>
            <span class="bal">₹<span id="modalBal">{{ auth()->user()->wallet->balance ?? 0 }}</span></span>
        </div>
        <div class="modal-label">Bet Amount (Min ₹10)</div>
        <input type="number" class="amount-input" id="betAmount" value="10" min="10">
        <div class="quick-amounts">
            <button class="quick-amt" onclick="setAmt(10)">+₹10</button>
            <button class="quick-amt" onclick="setAmt(50)">+₹50</button>
            <button class="quick-amt" onclick="setAmt(100)">+₹100</button>
            <button class="quick-amt" onclick="setAmt(500)">+₹500</button>
            <button class="quick-amt" onclick="setAmt(1000)">+₹1000</button>
        </div>
        <button class="confirm-btn" id="confirmBtn" onclick="placeBet()">
            🎯 Confirm Bet
        </button>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
    // ── State ──
    let currentBetType  = '';
    let currentBetValue = '';
    let multiplier      = 1;
    let isLocked        = {{ $round->is_betting_locked ? 'true' : 'false' }};
    let secondsLeft     = {{ (int) $round->seconds_remaining }};
    let currentRoundId  = {{ $round->id }};
    let lastCheckedRound = null;

    // ── Timer ──
    function updateTimerUI(sec) {
        let m = Math.floor(sec / 60);
        let s = sec % 60;
        document.getElementById('t-m1').textContent = Math.floor(m / 10);
        document.getElementById('t-m2').textContent = m % 10;
        document.getElementById('t-s1').textContent = Math.floor(s / 10);
        document.getElementById('t-s2').textContent = s % 10;
    }

    // Local countdown — smooth timer
    setInterval(() => {
        if (secondsLeft > 0) secondsLeft--;
        updateTimerUI(secondsLeft);
        checkLock();
    }, 1000);


    // ── Speech Setup ──
const speech = window.speechSynthesis;
let lastSpokenSecond = -1;

function speak(text) {
    speech.cancel(); // Pehle wali speech band karo
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang   = 'hi-IN'; // Hindi voice
    utterance.rate   = 1.2;     // Thodi fast
    utterance.pitch  = 1;
    utterance.volume = 1;
    speech.speak(utterance);
}

// ── checkLock update karo ──
function checkLock() {
    const locked = secondsLeft <= 10;
    document.getElementById('lockBanner').classList.toggle('show', locked);
    document.querySelectorAll('.colour-btn, .bs-btn').forEach(b => b.disabled = locked);
    document.querySelectorAll('.num-ball').forEach(b => b.classList.toggle('locked', locked));

    // Last 10 sec mein countdown voice
    if (secondsLeft <= 10 && secondsLeft > 0) {
        if (secondsLeft !== lastSpokenSecond) {
            lastSpokenSecond = secondsLeft;
            speak(secondsLeft.toString());
        }
    }

    
}

    // ── AJAX Polling — SIRF EK ──
    setInterval(() => {
        fetch('{{ route("game.status") }}')
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;

                // Naya round aaya
                if (data.round_id !== currentRoundId) {
                    currentRoundId = data.round_id;
                    document.getElementById('periodId').textContent = data.round_id;
                    loadGameHistory();
                    showToast('🎲 New round Start!', 'success');

                    // Result check karo — sirf ek baar
                    if (lastCheckedRound !== data.round_id) {
                        lastCheckedRound = data.round_id;
                        checkResult();
                    }
                }

                // Seconds sync — sirf agar 3 se zyada difference ho
                if (Math.abs(secondsLeft - data.seconds_remaining) > 3) {
                    secondsLeft = data.seconds_remaining;
                }

                isLocked = data.is_locked;
                checkLock();
            })
            .catch(() => {}); // Silent fail
    }, 2000);

    // ── Result Check ──
    function checkResult() {
        fetch('{{ route("game.checkResult") }}')
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;

                const isWin = data.status === 'won';

                // Balance update instantly
                document.getElementById('walletBalance').textContent = data.new_balance;
                document.getElementById('modalBal').textContent      = data.new_balance;

                // Popup elements
                const emoji   = document.getElementById('resultEmoji');
                const title   = document.getElementById('resultTitle');
                const innerBox = document.getElementById('resultInnerBox');
                const number  = document.getElementById('resultNumber');
                const amount  = document.getElementById('resultAmount');
                const balance = document.getElementById('resultBalance');
                const closeBtn = document.getElementById('resultCloseBtn');

                if (isWin) {
                    emoji.textContent      = '🎉';
                    title.textContent      = 'You Won! 🏆';
                    title.className        = 'result-title win';
                    innerBox.className     = 'result-inner-box win';
                    number.className       = 'result-number win';
                    amount.className       = 'result-amount win';
                    amount.textContent     = '+₹' + data.winning_amount;
                    closeBtn.className     = 'result-close-btn win';
                } else {
                    emoji.textContent      = '😢';
                    title.textContent      = 'Better Luck!';
                    title.className        = 'result-title lose';
                    innerBox.className     = 'result-inner-box lose';
                    number.className       = 'result-number lose';
                    amount.className       = 'result-amount lose';
                    amount.textContent     = '-₹' + data.amount;
                    closeBtn.className     = 'result-close-btn lose';
                }

                number.textContent  = data.result_number;
                balance.textContent = data.new_balance;

                // Popup show karo
                document.getElementById('resultOverlay').classList.add('show');
            })
            .catch(() => {});
    }

    function closeResultPopup() {
        document.getElementById('resultOverlay').classList.remove('show');
    }

    // ── Multiplier ──
    function selectMult(el, val) {
        document.querySelectorAll('.mult-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
        multiplier = val;
    }

    // ── Modal ──
    const colorMap = {
        green: '#16a34a', violet: '#7c3aed',
        red: '#e8192c', big: '#f97316', small: '#2563eb',
        '0':'#7c3aed','1':'#16a34a','2':'#e8192c','3':'#16a34a',
        '4':'#e8192c','5':'#7c3aed','6':'#e8192c','7':'#16a34a',
        '8':'#e8192c','9':'#16a34a'
    };

    function openModal(type, value, label) {
        if (isLocked || secondsLeft <= 10) {
            showToast('🔒 Betting band hai! Next round wait karo.', 'error');
            return;
        }
        currentBetType  = type;
        currentBetValue = value;
        const badge = document.getElementById('modalBadge');
        badge.textContent      = label;
        badge.style.background = colorMap[value] || '#e8192c';
        document.getElementById('confirmBtn').style.background = colorMap[value] || '#e8192c';
        document.getElementById('betAmount').value = 10 * multiplier;
        document.getElementById('betModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('betModal').classList.remove('show');
    }

    function closeOutside(e) {
        if (e.target === document.getElementById('betModal')) closeModal();
    }

    function setAmt(a) {
        document.getElementById('betAmount').value = a * multiplier;
    }

    // ── Place Bet (AJAX) ──
    function placeBet() {
        const amount = document.getElementById('betAmount').value;
        const btn    = document.getElementById('confirmBtn');

        if (!amount || amount < 10) {
            showToast('❌ Minimum ₹10 bet!', 'error');
            return;
        }

        btn.disabled    = true;
        btn.textContent = 'Placing...';

        fetch('{{ route("game.bet") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                bet_type:  currentBetType,
                bet_value: currentBetValue,
                amount:    amount,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('walletBalance').textContent = data.new_balance;
                document.getElementById('modalBal').textContent      = data.new_balance;
                closeModal();
                showToast('✅ ' + data.message, 'success');
            } else {
                showToast('❌ ' + data.message, 'error');
            }
        })
        .catch(() => showToast('❌ Something went wrong!', 'error'))
        .finally(() => {
            btn.disabled    = false;
            btn.textContent = '🎯 Confirm Bet';
        });
    }

    // ── History Tabs ──
    function switchTab(el, tabId) {
        document.querySelectorAll('.history-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('game-history').style.display = tabId === 'game-history' ? 'block' : 'none';
        document.getElementById('my-history').style.display   = tabId === 'my-history'   ? 'block' : 'none';
        if (tabId === 'my-history') loadMyHistory();
    }

    // ── Load Game History ──
    function loadGameHistory() {
        fetch('{{ route("game.history") }}')
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                const body = document.getElementById('game-history-body');
                if (!data.rounds.length) {
                    body.innerHTML = '<div class="empty-msg">Koi history nahi!</div>';
                    return;
                }
                body.innerHTML = data.rounds.map(r => `
                    <div class="table-row">
                        <span class="period-id">${r.id}</span>
                        <span>${r.result_number}</span>
                        <span>${r.result_size ? r.result_size.charAt(0).toUpperCase() + r.result_size.slice(1) : '-'}</span>
                        <span><span class="color-dot dot-${r.result_color}"></span></span>
                    </div>
                `).join('');

                const recent = document.getElementById('recentResults');
                recent.innerHTML = data.rounds.slice(0, 6).map(r =>
                    `<div class="result-ball ball-${r.result_color}">${r.result_number}</div>`
                ).join('');
            });
    }

    // ── Load My History ──
    function loadMyHistory() {
        const body = document.getElementById('my-history-body');
        body.innerHTML = '<div class="empty-msg">Loading...</div>';

        fetch('{{ route("game.myHistory") }}')
            .then(r => r.json())
            .then(data => {
                if (!data.success || !data.bets.length) {
                    body.innerHTML = '<div class="empty-msg">No bet yet!</div>';
                    return;
                }
                body.innerHTML = data.bets.map(b => `
                    <div class="my-table-row">
                        <span class="period-id">${b.game_round_id}</span>
                        <span>${b.bet_value}</span>
                        <span>₹${b.amount}</span>
                        <span class="status-${b.status}">
                            ${b.status === 'won' ? '✅ Won' : b.status === 'lost' ? '❌ Lost' : '⏳'}
                        </span>
                    </div>
                `).join('');
            });
    }

    // ── Refresh Balance ──
    function refreshBalance() {
        fetch('{{ route("wallet.balance") }}')
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('walletBalance').textContent = data.balance;
                    document.getElementById('modalBal').textContent      = data.balance;
                    showToast('✅ Balance updated!', 'success');
                }
            });
    }

    // ── Toast ──
    function showToast(msg, type = '') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className   = 'toast show ' + type;
        setTimeout(() => t.className = 'toast', 2800);
    }




function closeHelp(e) {
    if (e.target === document.getElementById('helpModal')) {
        document.getElementById('helpModal').classList.remove('show');
    }
}
    // Init
    updateTimerUI(secondsLeft);
    checkLock();

    @if(session('success'))
        showToast('✅ {{ session("success") }}', 'success');
    @endif
    @if(session('error'))
        showToast('❌ {{ session("error") }}', 'error');
    @endif
</script>
</body>
</html>