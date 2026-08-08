<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Login — Lottery777</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --dark:   #1a1a2e;
            --dark2:  #2d2d44;
            --red:    #e8192c;
            --green:  #138808;
            --gray:   #6b7280;
            --light:  #f3f4f6;
            --shadow: 0 8px 32px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Background pattern */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(232,25,44,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(19,136,8,0.15) 0%, transparent 50%);
        }

        .container {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo-box {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, var(--dark2), #3d3d5c);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px;
            margin: 0 auto 12px;
            box-shadow: var(--shadow);
            border: 2px solid rgba(255,255,255,0.1);
        }

        .logo-title {
            font-family: 'Baloo 2', cursive;
            font-size: 24px;
            font-weight: 800;
            color: #fff;
        }

        .logo-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Card */
        .card {
            background: var(--dark2);
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .card-title {
            font-family: 'Baloo 2', cursive;
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
        }

        .card-sub {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            margin-bottom: 24px;
        }

        /* Form */
        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: rgba(255,255,255,0.6);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap { position: relative; }

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
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            outline: none;
            background: rgba(255,255,255,0.05);
            transition: border-color 0.2s, background 0.2s;
        }

        .form-input::placeholder { color: rgba(255,255,255,0.3); }

        .form-input:focus {
            border-color: var(--red);
            background: rgba(255,255,255,0.08);
        }

        .form-input.error { border-color: var(--red); }

        .error-msg {
            font-size: 11px;
            color: #f87171;
            font-weight: 700;
            margin-top: 4px;
        }

        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--red), #b91c1c);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 8px;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 15px rgba(232,25,44,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(232,25,44,0.5);
        }

        .btn-submit:active { transform: scale(0.98); }

        /* Alert */
        .alert {
            background: rgba(248,113,113,0.15);
            border: 1.5px solid rgba(248,113,113,0.3);
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #f87171;
            font-weight: 700;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0 0;
        }

        .divider-line { flex: 1; height: 1px; background: rgba(255,255,255,0.1); }
        .divider-text { font-size: 11px; color: rgba(255,255,255,0.3); font-weight: 700; }

        .user-link {
            text-align: center;
            margin-top: 14px;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            font-weight: 700;
        }

        .user-link a {
            color: var(--green);
            text-decoration: none;
            font-weight: 800;
        }

        /* Spinner */
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Security badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 11px;
            color: rgba(255,255,255,0.3);
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Logo -->
    <div class="logo-box">
        <div class="logo-icon">🔐</div>
        <div class="logo-title">Lottery777</div>
        <div class="logo-sub">Admin Portal</div>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-title">Admin Login</div>
        <div class="card-sub">Sirf authorized admins ke liye!</div>

        {{-- Error --}}
        @if($errors->any())
        <div class="alert">❌ {{ $errors->first() }}</div>
        @endif

        @if(session('error'))
        <div class="alert">❌ {{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" onsubmit="handleSubmit()">
            @csrf

            <!-- Phone -->
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <div class="input-wrap">
                    <span class="input-icon">📱</span>
                    <input
                        type="tel"
                        name="phone"
                        class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
                        placeholder="Admin phone number"
                        value="{{ old('phone') }}"
                        maxlength="15"
                        required
                        autofocus
                    >
                </div>
                @error('phone')
                    <div class="error-msg">⚠ {{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="Admin password"
                        required
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass()">👁</button>
                </div>
                @error('password')
                    <div class="error-msg">⚠ {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit" id="loginBtn">
                <div class="spinner" id="spinner"></div>
                <span id="btnText">🔐 Admin Login</span>
            </button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-text">NOT AN ADMIN?</div>
            <div class="divider-line"></div>
        </div>

        <div class="user-link">
            User hain? <a href="{{ route('login') }}">User Login →</a>
        </div>
    </div>

    <div class="security-badge">
        🛡️ Secured Admin Access Only
    </div>

</div>

<script>
    function togglePass() {
        const field = document.getElementById('password');
        const btn   = document.querySelector('.toggle-pass');
        if (field.type === 'password') {
            field.type = 'text';
            btn.textContent = '🙈';
        } else {
            field.type = 'password';
            btn.textContent = '👁';
        }
    }

    function handleSubmit() {
        const btn     = document.getElementById('loginBtn');
        const spinner = document.getElementById('spinner');
        const txt     = document.getElementById('btnText');
        btn.disabled        = true;
        spinner.style.display = 'block';
        txt.textContent     = 'Logging in...';
    }
</script>

</body>
</html>