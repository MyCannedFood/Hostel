<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - HDS</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1A3D0A;
            --primary-hover: #142f07;
            --primary-light: rgba(26, 61, 10, 0.08);
            --primary-focus: rgba(26, 61, 10, 0.15);
            --border: #e0e0e0;
            --text: #2b2b2b;
            --muted: #9e9e9e;
            --error: #c0392b;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #c9b99a;
            background-image: url('{{ asset('images/hero.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.25);
        }

        .login-card {
            background: var(--white);
            border-radius: 18px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.22);
            width: 100%;
            max-width: 430px;
            padding: 48px 44px 44px;
            position: relative;
            z-index: 1;
            animation: fadeUp 0.45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Logo ── */
        .logo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 36px;
        }

        .logo-wrap img {
            height: 56px;
            width: auto;
            object-fit: contain;
        }

        /* fallback text logo when no image */
        .logo-text {
            font-size: 42px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
            line-height: 1;
        }

        /* ── Labels ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text);
            font-weight: 600;
            font-size: 14px;
        }

        /* ── Inputs ── */
        .input-wrap {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 13px 44px 13px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: #fafafa;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        }

        .form-group input::placeholder {
            color: var(--muted);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px var(--primary-focus);
        }

        /* toggle eye */
        .eye-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            display: flex;
            align-items: center;
            padding: 0;
            transition: color 0.2s;
        }

        .eye-btn:hover { color: var(--primary); }

        /* ── Submit ── */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            margin-top: 26px;
            letter-spacing: 0.3px;
            transition: background 0.22s, transform 0.18s, box-shadow 0.22s;
        }

        .login-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(26,61,10,0.28);
        }

        .login-btn:active {
            transform: translateY(0);
            box-shadow: none;
        }

        /* ── Errors ── */
        .alert-error {
            margin-bottom: 22px;
            padding: 11px 14px;
            background: #fdecea;
            border: 1px solid #f5c6c2;
            border-radius: 8px;
            color: var(--error);
            font-size: 13px;
        }

        .field-error {
            color: var(--error);
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-card">

        <div class="logo-wrap">
            <img src="{{ asset('images/logo_only.png') }}" alt="HDS Logo"
                 onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='block'">
            <span id="logo-fallback" class="logo-text" style="display:none;">H<span style="font-size:32px;">🦷</span>S</span>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email Admin"
                        required
                        autofocus>
                </div>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password Admin"
                        required>
                    <button type="button" class="eye-btn" onclick="togglePassword()" aria-label="Tampilkan password">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-btn">Masuk</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>`;
            }
        }
    </script>
</body>
</html>