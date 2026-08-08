<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Help Center — Lottery777</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        :root {
            --red: #e8192c; --green: #138808; --violet: #7c3aed;
            --orange: #f97316; --blue: #2563eb; --dark: #1a1a2e;
            --gray: #6b7280; --light: #f3f4f6; --shadow: 0 4px 16px rgba(0,0,0,0.10);
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
            padding-bottom: 40px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, var(--red), #b91c1c);
            padding: 14px 16px 24px;
            border-radius: 0 0 24px 24px;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 10px;
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

        .header-subtitle {
            color: rgba(255,255,255,0.85);
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .header-icon {
            text-align: center;
            font-size: 40px;
            margin-bottom: 6px;
        }

        /* Section Title */
        .section-title {
            font-size: 14px;
            font-weight: 800;
            color: #374151;
            padding: 16px 12px 8px;
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 0 12px;
            margin-bottom: 4px;
        }

        .info-card {
            background: #fff;
            border-radius: 14px;
            padding: 14px;
            box-shadow: var(--shadow);
        }

        .info-card .card-icon { font-size: 24px; margin-bottom: 6px; }
        .info-card .card-title { font-size: 12px; font-weight: 800; color: #1f2937; margin-bottom: 4px; }
        .info-card .card-desc  { font-size: 11px; font-weight: 600; color: var(--gray); line-height: 1.5; }

        /* How to Play */
        .how-card {
            margin: 0 12px 10px;
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            box-shadow: var(--shadow);
        }

        .how-title {
            font-size: 13px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .step:last-child { margin-bottom: 0; }

        .step-num {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            line-height: 1.5;
            padding-top: 3px;
        }

        /* Payout Table */
        .payout-card {
            margin: 0 12px 10px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .payout-head {
            background: var(--dark);
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 10px 14px;
        }

        .payout-head span {
            font-size: 11px;
            font-weight: 800;
            color: rgba(255,255,255,0.8);
            text-transform: uppercase;
        }

        .payout-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 10px 14px;
            border-bottom: 1px solid #f3f4f6;
            align-items: center;
        }

        .payout-row:last-child { border-bottom: none; }

        .payout-row span {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
        }

        .payout-row .multiplier {
            font-size: 14px;
            font-weight: 900;
            color: var(--green);
        }

        /* Color Mapping */
        .color-map-card {
            margin: 0 12px 10px;
            background: #fff;
            border-radius: 14px;
            padding: 14px;
            box-shadow: var(--shadow);
        }

        .color-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .color-row:last-child { margin-bottom: 0; }

        .color-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            color: #fff;
            min-width: 70px;
            text-align: center;
        }

        .badge-green  { background: var(--green); }
        .badge-red    { background: var(--red); }
        .badge-violet { background: var(--violet); }
        .badge-big    { background: var(--orange); }
        .badge-small  { background: var(--blue); }

        .color-numbers {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
        }

        /* FAQ */
        .faq-card {
            margin: 0 12px 10px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .faq-item {
            border-bottom: 1px solid #f3f4f6;
        }

        .faq-item:last-child { border-bottom: none; }

        .faq-question {
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 800;
            color: #1f2937;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-answer {
            display: none;
            padding: 0 14px 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gray);
            line-height: 1.6;
        }

        .faq-answer.show { display: block; }
        .faq-arrow { transition: transform 0.2s; font-size: 12px; }
        .faq-arrow.open { transform: rotate(180deg); }

        /* Warning */
        .warning-card {
            margin: 0 12px 10px;
            background: #fff7ed;
            border: 1.5px solid #fed7aa;
            border-radius: 14px;
            padding: 14px;
        }

        .warning-title {
            font-size: 13px;
            font-weight: 800;
            color: #9a3412;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .warning-text {
            font-size: 11px;
            font-weight: 700;
            color: #9a3412;
            line-height: 1.6;
        }

        /* Query Form */
        .query-card {
            margin: 0 12px 10px;
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            box-shadow: var(--shadow);
        }

        .query-title {
            font-family: 'Baloo 2', cursive;
            font-size: 18px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .query-sub {
            font-size: 12px;
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 16px;
        }

        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            outline: none;
            transition: border-color 0.2s;
            background: #fafafa;
        }

        .form-input:focus { border-color: var(--red); background: #fff; }

        textarea.form-input {
            resize: none;
            height: 100px;
            line-height: 1.5;
        }

        .submit-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--red), #b91c1c);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(232,25,44,0.3);
            transition: transform 0.15s;
        }

        .submit-btn:active { transform: scale(0.97); }

        /* Alert */
        .alert-success {
            background: #dcfce7;
            border: 1.5px solid #86efac;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 14px;
            font-size: 12px;
            font-weight: 700;
            color: #15803d;
        }

        .alert-error {
            background: #fee2e2;
            border: 1.5px solid #fca5a5;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 14px;
            font-size: 12px;
            font-weight: 700;
            color: var(--red);
        }

        /* Contact Info */
        .contact-card {
            margin: 0 12px 10px;
            background: linear-gradient(135deg, var(--dark), #2d2d44);
            border-radius: 14px;
            padding: 16px;
            color: #fff;
        }

        .contact-title {
            font-family: 'Baloo 2', cursive;
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
            color: rgba(255,255,255,0.85);
        }

        .contact-item:last-child { margin-bottom: 0; }
    </style>
</head>
<body>
<div class="app">

    <!-- HEADER -->
    <div class="header">
        <div class="header-top">
            <a class="back-btn" href="{{ route('game.index') }}">&#8249;</a>
            <div class="header-title">Help Center</div>
        </div>
        <div class="header-icon">🎯</div>
        <div class="header-subtitle">Everything you need to know about Lottery777</div>
    </div>

    <!-- ABOUT GAME -->
    <div class="section-title">About The Game</div>
    <div class="info-grid">
        <div class="info-card">
            <div class="card-icon">⏱️</div>
            <div class="card-title">Round Duration</div>
            <div class="card-desc">Every round lasts exactly 60 seconds. A new round starts automatically every minute.</div>
        </div>
        <div class="info-card">
            <div class="card-icon">🎲</div>
            <div class="card-title">Prediction Types</div>
            <div class="card-desc">Predict Colour (Green/Red/Violet), Number (0-9), or Size (Big/Small).</div>
        </div>
        <div class="info-card">
            <div class="card-icon">💰</div>
            <div class="card-title">Min Bet</div>
            <div class="card-desc">Minimum bet amount is ₹10 per round. No maximum limit.</div>
        </div>
        <div class="info-card">
            <div class="card-icon">🔒</div>
            <div class="card-title">Betting Lock</div>
            <div class="card-desc">Betting is locked in the last 10 seconds of every round.</div>
        </div>
    </div>

    <!-- HOW TO PLAY -->
    <div class="section-title">How To Play</div>
    <div class="how-card">
        <div class="how-title">📋 Step by Step Guide</div>

        <div class="step">
            <div class="step-num">1</div>
            <div class="step-text">Register your account and complete the verification process.</div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-text">Deposit funds into your wallet using UPI payment and submit your UTR number.</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-text">Wait for admin to approve your deposit. Balance will be added instantly after approval.</div>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <div class="step-text">Go to the game page and choose your prediction — Colour, Number, or Big/Small.</div>
        </div>
        <div class="step">
            <div class="step-num">5</div>
            <div class="step-text">Enter your bet amount and confirm. Wait for the round to end.</div>
        </div>
        <div class="step">
            <div class="step-num">6</div>
            <div class="step-text">Result is announced every minute. Winners receive their payout instantly in their wallet.</div>
        </div>
        <div class="step">
            <div class="step-num">7</div>
            <div class="step-text">Withdraw your winnings anytime by submitting a withdrawal request.</div>
        </div>
    </div>

    <!-- PAYOUT TABLE -->
    <div class="section-title">Payout Structure</div>
    <div class="payout-card">
        <div class="payout-head">
            <span>Bet Type</span>
            <span>Example</span>
            <span>Payout</span>
        </div>
        <div class="payout-row">
            <span>🔢 Number</span>
            <span>Bet on 7</span>
            <span class="multiplier">10x</span>
        </div>
        <div class="payout-row">
            <span>🎨 Colour</span>
            <span>Bet on Green</span>
            <span class="multiplier">3x</span>
        </div>
        <div class="payout-row">
            <span>📊 Big</span>
            <span>Bet on Big</span>
            <span class="multiplier">2x</span>
        </div>
        <div class="payout-row">
            <span>📊 Small</span>
            <span>Bet on Small</span>
            <span class="multiplier">2x</span>
        </div>
    </div>

    <!-- COLOR MAPPING -->
    <div class="section-title">Colour & Size Mapping</div>
    <div class="color-map-card">
        <div class="color-row">
            <span class="color-badge badge-green">🟢 Green</span>
            <span class="color-numbers">Numbers: 1, 3, 7, 9</span>
        </div>
        <div class="color-row">
            <span class="color-badge badge-red">🔴 Red</span>
            <span class="color-numbers">Numbers: 2, 4, 6, 8</span>
        </div>
        <div class="color-row">
            <span class="color-badge badge-violet">🟣 Violet</span>
            <span class="color-numbers">Numbers: 0, 5</span>
        </div>
        <div class="color-row">
            <span class="color-badge badge-big">📈 Big</span>
            <span class="color-numbers">Numbers: 5, 6, 7, 8, 9</span>
        </div>
        <div class="color-row">
            <span class="color-badge badge-small">📉 Small</span>
            <span class="color-numbers">Numbers: 0, 1, 2, 3, 4</span>
        </div>
    </div>

    <!-- FAQ -->
    <div class="section-title">Frequently Asked Questions</div>
    <div class="faq-card">
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                How long does deposit approval take?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Deposits are usually approved within 30 minutes to 2 hours during business hours. Please ensure you submit the correct UTR number after making the payment.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                How long does withdrawal take?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Withdrawal requests are processed within 24 hours. Amount is transferred directly to your UPI ID.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                What is the minimum withdrawal amount?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                The minimum withdrawal amount is ₹100. There is no maximum withdrawal limit.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Can I place multiple bets in one round?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Yes! You can place bets on multiple options in the same round — colour, number, and size simultaneously.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                What happens if the game crashes during a round?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Don't worry! All bets are saved in our secure database. Results are processed automatically by our server regardless of connection issues.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                Is my money safe on Lottery777?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Yes. All transactions are recorded securely. Your wallet balance is always protected and visible in your account at all times.
            </div>
        </div>
    </div>

    <!-- WARNING -->
    <div class="warning-card">
        <div class="warning-title">⚠️ Responsible Gaming Notice</div>
        <div class="warning-text">
            Lottery777 is a risk-based prediction game. There is a possibility of financial loss. Please play responsibly and only bet what you can afford to lose. This game involves financial risk and users are solely responsible for their own decisions and losses.
        </div>
    </div>

    <!-- CONTACT -->
    <div class="section-title">Contact Us</div>
    <div class="contact-card">
        <div class="contact-title">📞 Get In Touch</div>
        <div class="contact-item">📧 Email: support@lottery777.online</div>
        <div class="contact-item">⏰ Support Hours: 9 AM – 9 PM (Mon–Sat)</div>
        <div class="contact-item">⚡ Response Time: Within 24 hours</div>
    </div>

    <!-- QUERY FORM -->
    <div class="section-title">Submit a Query</div>
    <div class="query-card">
        <div class="query-title">📩 Contact Support</div>
        <div class="query-sub">Have a question? Fill the form below and we'll reply to your email within 24 hours.</div>

        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert-error">❌ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('help.query') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-input"
                    placeholder="Enter your full name"
                    value="{{ old('name', auth()->user()->name ?? '') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input
                    type="email"
                    name="email"
                    class="form-input"
                    placeholder="Enter your email address"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Your Message</label>
                <textarea
                    name="message"
                    class="form-input"
                    placeholder="Describe your issue or question in detail..."
                    required
                >{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="submit-btn">
                📤 Submit Query
            </button>
        </form>
    </div>

</div>

<script>
    function toggleFaq(el) {
        const answer = el.nextElementSibling;
        const arrow  = el.querySelector('.faq-arrow');
        answer.classList.toggle('show');
        arrow.classList.toggle('open');
    }
</script>
</body>
</html>