<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Register — Lottery777</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --red: #e8192c;
            --green: #138808;
            --white: #ffffff;
            --light: #f5f5f5;
            --gray: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 8px 32px rgba(0,0,0,0.12);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f0f0f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 420px;
        }

        /* ── Logo ── */
        .logo-box {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-flag {
            display: flex;
            width: 64px;
            height: 64px;
            border-radius: 16px;
            overflow: hidden;
            margin: 0 auto 10px;
            box-shadow: var(--shadow);
        }

        .flag-green { flex: 1; background: var(--green); }
        .flag-white { flex: 1; background: var(--white); display: flex; align-items: center; justify-content: center; }
        .flag-red   { flex: 1; background: var(--red); }

        .flag-chakra {
            width: 16px; height: 16px;
            border: 2px solid #000080;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px;
        }

        .logo-title {
            font-family: 'Baloo 2', cursive;
            font-size: 26px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--green), var(--red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-sub {
            font-size: 12px;
            color: var(--gray);
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* Tiranga top bar */
        .tiranga-bar {
            display: flex;
            height: 6px;
        }
        .tiranga-bar .t1 { flex: 1; background: var(--green); }
        .tiranga-bar .t2 { flex: 1; background: var(--white); border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
        .tiranga-bar .t3 { flex: 1; background: var(--red); }

        .card-body { padding: 28px 24px; }

        .card-title {
            font-family: 'Baloo 2', cursive;
            font-size: 22px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .card-sub {
            font-size: 13px;
            color: var(--gray);
            font-weight: 600;
            margin-bottom: 22px;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 800;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 38px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fafafa;
        }

        .form-input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(19,136,8,0.1);
            background: #fff;
        }

        .form-input.error { border-color: var(--red); }

        .error-msg {
            font-size: 11px;
            color: var(--red);
            font-weight: 700;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Password toggle */
        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: var(--gray);
        }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--green), #0d6b06);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 8px;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 15px rgba(19,136,8,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(19,136,8,0.4);
        }

        .btn-submit:active { transform: scale(0.98); }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
        }

        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text { font-size: 12px; color: var(--gray); font-weight: 700; }

        /* ── Login Link ── */
        .login-link {
            text-align: center;
            font-size: 13px;
            color: var(--gray);
            font-weight: 700;
        }

        .login-link a {
            color: var(--red);
            text-decoration: none;
            font-weight: 800;
        }

        .login-link a:hover { text-decoration: underline; }

        /* ── Alert ── */
        .alert {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 12px;
            color: var(--red);
            font-weight: 700;
        }

        /* Tiranga bottom bar */
        .tiranga-bar-bottom {
            display: flex;
            height: 4px;
        }
        .tiranga-bar-bottom .b1 { flex: 1; background: var(--red); }
        .tiranga-bar-bottom .b2 { flex: 1; background: var(--white); border-top: 1px solid #eee; }
        .tiranga-bar-bottom .b3 { flex: 1; background: var(--green); }
    </style>
</head>
<body>

<div class="container">

    <!-- Logo -->
    <div class="logo-box">
        <div class="logo-title">Lottery777</div>
        <div class="logo-sub">Color Prediction Game</div>
    </div>

    <!-- Warning Notice -->
<div style="
    background: #fef9c3;
    border: 1.5px solid #fde68a;
    border-radius: 12px;
    padding: 10px 14px;
    margin-bottom: 16px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
">
    <span style="font-size:16px;flex-shrink:0;">⚠️</span>
    <p style="font-size:11px;font-weight:700;color:#92400e;line-height:1.6;margin:0;">
        इस गेम में भाग लेने से पहले ध्यान दें कि इसमें वित्तीय जोखिम शामिल है। किसी भी प्रकार की हानि के लिए उपयोगकर्ता स्वयं जिम्मेदार होगा।
    </p>
</div>

    <!-- Card -->
    <div class="card">
        <div class="tiranga-bar">
            <div class="t1"></div>
            <div class="t2"></div>
            <div class="t3"></div>
        </div>

        <div class="card-body">
            <div class="card-title">Create Account 🎯</div>
            <div class="card-sub">Register Here</div>

            {{-- Error Messages --}}
            @if($errors->any())
            <div class="alert">
                ❌ {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('register_post') }}">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon">👤</span>
                        <input
                            type="text"
                            name="name"
                            class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                            placeholder="Name"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>
                    @error('name')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <div class="input-wrap">
                        <span class="input-icon">📱</span>
                        <input
                            type="tel"
                            name="phone"
                            class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
                            placeholder="10 digit phone number"
                            value="{{ old('phone') }}"
                            maxlength="15"
                            required
                        >
                    </div>
                    @error('phone')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                            placeholder="Min 6 characters"
                            required
                        >
                        <button type="button" class="toggle-pass" onclick="togglePass('password', this)">👁</button>
                    </div>
                    @error('password')
                        <div class="error-msg">⚠ {{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-input"
                            placeholder="Confirm Password"
                            required
                        >
                        <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', this)">👁</button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    🚀 Register
                </button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">ALREADY HAVE ACCOUNT?</div>
                <div class="divider-line"></div>
            </div>

            <div class="login-link">
                Login Here <a href="{{ route('login') }}">Login →</a>
            </div>
        </div>

        <div class="tiranga-bar-bottom">
            <div class="b1"></div>
            <div class="b2"></div>
            <div class="b3"></div>
        </div>
    </div>

</div>

<script>
    function togglePass(fieldId, btn) {
        const field = document.getElementById(fieldId);
        if (field.type === 'password') {
            field.type = 'text';
            btn.textContent = '🙈';
        } else {
            field.type = 'password';
            btn.textContent = '👁';
        }
    }
</script>

</body>
</html>