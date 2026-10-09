<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --red: #e8192c; --dark: #1a1a2e; --gray: #6b7280; --light: #f3f4f6; --shadow: 0 4px 16px rgba(0,0,0,.1); }
        body { font-family: 'Nunito', sans-serif; background: var(--light); color: #1f2937; }
        .app { width: 100%; max-width: 430px; min-height: 100vh; margin: auto; padding-bottom: 90px; }
        .header { background: linear-gradient(135deg, var(--dark), #2d2d44); color: #fff; padding: 16px; border-radius: 0 0 22px 22px; }
        .header-top { display: flex; align-items: center; gap: 12px; }
        .back { color: #fff; text-decoration: none; font-size: 28px; line-height: 1; }
        h1 { font: 800 22px 'Baloo 2', cursive; }
        .subtitle { color: #cbd5e1; font-size: 12px; margin-top: 2px; }
        .form { padding: 14px 12px; }
        .module { background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: var(--shadow); }
        .module h2 { font: 800 17px 'Baloo 2', cursive; margin-bottom: 12px; }
        .module p { color: var(--gray); font-size: 11px; margin: -7px 0 12px; }
        label { display: block; color: #4b5563; font-size: 12px; font-weight: 800; margin: 10px 0 6px; }
        input { width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 11px 12px; font: 700 14px 'Nunito', sans-serif; color: #1f2937; }
        input:focus { outline: none; border-color: var(--red); }
        .file { padding: 9px; background: #f9fafb; }
        .preview { display: block; width: 130px; height: 130px; object-fit: contain; border: 1px dashed #d1d5db; border-radius: 10px; margin: 4px 0 12px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .coupon-row { border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px; margin-bottom: 10px; }
        .coupon-row-top { display: flex; align-items: center; gap: 8px; }
        .coupon-row-top input { flex: 1; }
        .remove-coupon { border: 0; background: #fee2e2; color: #b91c1c; border-radius: 8px; width: 38px; height: 38px; font-size: 18px; cursor: pointer; }
        .add-coupon { border: 2px dashed #d1d5db; background: #f9fafb; color: #374151; border-radius: 10px; width: 100%; padding: 10px; font: 800 12px 'Nunito', sans-serif; cursor: pointer; }
        .save { width: 100%; border: 0; border-radius: 12px; padding: 14px; background: linear-gradient(135deg, var(--red), #b91c1c); color: #fff; font: 800 15px 'Nunito', sans-serif; cursor: pointer; }
        .alert { margin: 14px 12px 0; padding: 11px 13px; border-radius: 10px; font-size: 12px; font-weight: 800; }
        .success { background: #dcfce7; color: #166534; } .errors { background: #fee2e2; color: #991b1b; }
        .bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 430px; display: flex; background: #fff; border-top: 1px solid #e5e7eb; box-shadow: 0 -4px 16px rgba(0,0,0,.08); }
        .nav-item { flex: 1; padding: 10px 4px; text-align: center; text-decoration: none; color: #9ca3af; font-size: 10px; font-weight: 800; }
        .nav-item.active { color: var(--red); } .nav-icon { font-size: 19px; margin-bottom: 2px; }
    </style>
</head>
<body>
<div class="app">
    <header class="header">
        <div class="header-top"><a class="back" href="{{ route('admin.dashboard') }}">&#8249;</a><div><h1>Settings</h1><div class="subtitle">Manage your game modules</div></div></div>
    </header>

    @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert errors">{{ $errors->first() }}</div> @endif

    <form class="form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <section class="module">
            <h2>General Module</h2>
            <p>Basic information shown across the application.</p>
            <label for="app_name">App name</label>
            <input id="app_name" name="app_name" value="{{ old('app_name', $settings->get('app_name', 'Lottery777')) }}" maxlength="100">
        </section>

        <section class="module">
            <h2>Coupon Module</h2>
            <p>Users can apply these codes to receive a bonus after approval.</p>
            <div id="coupon-list">
                @forelse($coupons as $index => $coupon)
                    <div class="coupon-row">
                        <input type="hidden" name="coupons[{{ $index }}][id]" value="{{ $coupon->id }}">
                        <div class="coupon-row-top">
                            <input name="coupons[{{ $index }}][code]" value="{{ $coupon->code }}" placeholder="Coupon code" maxlength="50" required>
                            <button type="button" class="remove-coupon" onclick="removeCoupon(this)" title="Remove coupon">×</button>
                        </div>
                        <div class="grid">
                            <div><label>Bonus percentage</label><input type="number" name="coupons[{{ $index }}][bonus_percentage]" value="{{ $coupon->bonus_percentage }}" min="0.01" max="100" step="0.01" required></div>
                            <div><label>Minimum deposit</label><input type="number" name="coupons[{{ $index }}][min_deposit]" value="{{ $coupon->min_deposit }}" min="0" step="0.01"></div>
                            <div><label>Maximum uses</label><input type="number" name="coupons[{{ $index }}][max_uses]" value="{{ $coupon->max_uses }}" min="1" placeholder="Unlimited"></div>
                            <div><label>Expires at</label><input type="datetime-local" name="coupons[{{ $index }}][expires_at]" value="{{ $coupon->expires_at?->format('Y-m-d\\TH:i') }}"></div>
                        </div>
                        <label><input type="hidden" name="coupons[{{ $index }}][active]" value="0"><input type="checkbox" name="coupons[{{ $index }}][active]" value="1" @checked($coupon->active)> Active</label>
                        <small style="color:#6b7280;font-size:11px;">Used: {{ $coupon->used_count }}</small>
                    </div>
                @empty
                @endforelse
            </div>
            <button type="button" class="add-coupon" onclick="addCoupon()">＋ Add another coupon</button>
        </section>

        <section class="module">
            <h2>Payment Module</h2>
            <p>Update the UPI details and QR code used for deposits.</p>
            @if($settings->get('payment_qr_path'))
                <img class="preview" src="{{ '/storage/' . ltrim($settings->get('payment_qr_path'), '/') }}" alt="Current payment QR code">
            @else
                <img class="preview" src="{{ asset('images/qr-code.png') }}" alt="Current payment QR code">
            @endif
            <label for="payment_qr">QR-code file</label>
            <input class="file" id="payment_qr" type="file" name="payment_qr" accept="image/jpeg,image/png,image/webp">
            <label for="payment_upi_id">UPI ID</label>
            <input id="payment_upi_id" name="payment_upi_id" value="{{ old('payment_upi_id', $settings->get('payment_upi_id', 'prakasao482@ptaxis')) }}" required maxlength="120">
            <small style="display:block;color:#6b7280;font-size:11px;margin-top:7px;">JPG, PNG or WEBP up to 2 MB.</small>
        </section>

        <section class="module">
            <h2>Game Module</h2>
            <p>Set the basic game timing and limits.</p>
            <div class="grid">
                <div><label for="min_deposit">Minimum deposit</label><input id="min_deposit" type="number" name="min_deposit" min="1" step="0.01" value="{{ old('min_deposit', $settings->get('min_deposit', '100')) }}" required></div>
                <div><label for="min_withdrawal">Minimum withdrawal</label><input id="min_withdrawal" type="number" name="min_withdrawal" min="1" step="0.01" value="{{ old('min_withdrawal', $settings->get('min_withdrawal', '100')) }}" required></div>
            </div>
            <label for="round_duration">Round duration (seconds)</label>
            <input id="round_duration" type="number" name="round_duration" min="10" max="3600" value="{{ old('round_duration', $settings->get('round_duration', '60')) }}" required>
        </section>

        <section class="module">
            <h2>Support Module</h2>
            <p>Contact details for help requests.</p>
            <label for="support_phone">Support phone</label>
            <input id="support_phone" name="support_phone" value="{{ old('support_phone', $settings->get('support_phone')) }}" maxlength="30">
            <label for="support_email">Support email</label>
            <input id="support_email" type="email" name="support_email" value="{{ old('support_email', $settings->get('support_email')) }}" maxlength="120">
        </section>

        <button class="save" type="submit">Save all settings</button>
    </form>

    <nav class="bottom-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><div class="nav-icon">🏠</div>Dashboard</a>
        <a href="{{ route('admin.users') }}" class="nav-item"><div class="nav-icon">👥</div>Users</a>
        <a href="{{ route('admin.settings') }}" class="nav-item active"><div class="nav-icon">⚙️</div>Settings</a>
    </nav>
</div>
<script>
    let couponIndex = {{ $coupons->count() }};

    function addCoupon() {
        const row = document.createElement('div');
        row.className = 'coupon-row';
        row.innerHTML = `
            <div class="coupon-row-top">
                <input name="coupons[${couponIndex}][code]" placeholder="Coupon code" maxlength="50" required>
                <button type="button" class="remove-coupon" onclick="removeCoupon(this)" title="Remove coupon">×</button>
            </div>
            <div class="grid">
                <div><label>Bonus percentage</label><input type="number" name="coupons[${couponIndex}][bonus_percentage]" value="10" min="0.01" max="100" step="0.01" required></div>
                <div><label>Minimum deposit</label><input type="number" name="coupons[${couponIndex}][min_deposit]" value="0" min="0" step="0.01"></div>
                <div><label>Maximum uses</label><input type="number" name="coupons[${couponIndex}][max_uses]" min="1" placeholder="Unlimited"></div>
                <div><label>Expires at</label><input type="datetime-local" name="coupons[${couponIndex}][expires_at]"></div>
            </div>
            <label><input type="hidden" name="coupons[${couponIndex}][active]" value="0"><input type="checkbox" name="coupons[${couponIndex}][active]" value="1" checked> Active</label>`;
        document.getElementById('coupon-list').appendChild(row);
        couponIndex++;
    }

    function removeCoupon(button) {
        button.closest('.coupon-row').remove();
    }
</script>
</body>
</html>