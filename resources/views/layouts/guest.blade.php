<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Notepad') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #1a1a1a;
            color: #e5e5e5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 400px;
        }

        /* Brand */
        .auth-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 1.75rem;
            text-decoration: none;
            width: fit-content;
        }

        .auth-brand-icon {
            width: 34px;
            height: 34px;
            background-color: #ea580c;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            flex-shrink: 0;
        }

        .auth-brand-name {
            font-size: 1.0625rem;
            font-weight: 600;
            color: #f5f5f5;
            letter-spacing: -0.02em;
        }

        /* Card */
        .auth-card {
            background: #242424;
            border: 1px solid #2e2e2e;
            border-radius: 14px;
            padding: 2rem;
        }

        /* Title */
        .auth-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #f5f5f5;
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
        }

        .auth-subtitle {
            font-size: 0.875rem;
            color: #737373;
            margin-bottom: 1.75rem;
        }

        /* Form */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #a3a3a3;
            margin-bottom: 0.375rem;
        }

        .form-input {
            display: block;
            width: 100%;
            padding: 0.6rem 0.875rem;
            background: #2a2a2a;
            border: 1.5px solid #3a3a3a;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            color: #f5f5f5;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.15);
        }

        .form-input::placeholder {
            color: #525252;
        }

        .form-error {
            font-size: 0.8rem;
            color: #f87171;
            margin-top: 0.375rem;
        }

        /* Inline row (label + link) */
        .form-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.375rem;
        }

        .forgot-link {
            font-size: 0.8rem;
            color: #737373;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #ea580c;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .form-checkbox {
            width: 15px;
            height: 15px;
            accent-color: #ea580c;
            cursor: pointer;
            flex-shrink: 0;
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: #737373;
            cursor: pointer;
        }

        /* Button */
        .btn-auth {
            display: block;
            width: 100%;
            padding: 0.7rem 1.25rem;
            background-color: #ea580c;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.15s;
            text-align: center;
        }

        .btn-auth:hover {
            background-color: #c2410c;
            transform: translateY(-1px);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.875rem;
            color: #737373;
        }

        .auth-footer a {
            color: #ea580c;
            font-weight: 500;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Session status */
        .session-status {
            background: rgba(74, 222, 128, 0.1);
            border: 1px solid rgba(74, 222, 128, 0.2);
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            color: #4ade80;
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">

        <a href="{{ url('/') }}" class="auth-brand">
            <div class="auth-brand-icon">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <span class="auth-brand-name">{{ config('app.name', 'Notepad') }}</span>
        </a>

        <div class="auth-card">
            {{ $slot }}
        </div>

    </div>
</body>
</html>
