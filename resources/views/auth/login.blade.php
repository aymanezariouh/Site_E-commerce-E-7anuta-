<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Log in</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @media (prefers-reduced-motion: no-preference) {
                .login-enter-left {
                    animation: login-enter-left 700ms cubic-bezier(0.22, 1, 0.36, 1) both;
                }

                .login-enter-right {
                    animation: login-enter-right 760ms cubic-bezier(0.22, 1, 0.36, 1) both;
                }

                .login-orb {
                    animation: login-orb 11s ease-in-out infinite;
                }
            }

            @keyframes login-enter-left {
                from {
                    opacity: 0;
                    transform: translateX(-24px) translateY(18px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0) translateY(0);
                }
            }

            @keyframes login-enter-right {
                from {
                    opacity: 0;
                    transform: translateX(24px) translateY(18px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0) translateY(0);
                }
            }

            @keyframes login-orb {
                0%,
                100% {
                    transform: translateY(0) scale(1);
                }

                50% {
                    transform: translateY(-12px) scale(1.05);
                }
            }
        </style>
    </head>
    <body class="min-h-screen bg-shop-gray-950 antialiased">
        <div class="relative isolate min-h-screen overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_0%,rgba(34,197,94,0.18),transparent_38%),radial-gradient(circle_at_90%_12%,rgba(251,191,36,0.22),transparent_32%),linear-gradient(145deg,#0f172a_10%,#111827_50%,#052e16_100%)]"></div>
            <div class="login-orb absolute -top-28 right-10 h-64 w-64 rounded-full bg-gradient-to-br from-brand-300/30 to-brand-700/10 blur-3xl"></div>
            <div class="login-orb absolute bottom-8 -left-20 h-56 w-56 rounded-full bg-gradient-to-tr from-amber-300/20 to-amber-500/5 blur-3xl"></div>

            <div class="relative mx-auto flex min-h-screen w-full max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
                <div class="grid w-full gap-5 lg:grid-cols-[1.1fr_0.9fr] lg:gap-7">
                    <section class="login-enter-left relative overflow-hidden rounded-[2rem] border border-white/20 bg-white/10 p-7 text-white shadow-2xl shadow-black/25 backdrop-blur-xl sm:p-10 lg:p-12">
                        <div class="absolute right-6 top-6 h-24 w-24 rounded-3xl border border-white/20 bg-white/10"></div>
                        <div class="absolute -bottom-8 right-24 h-28 w-28 rounded-full border border-white/10 bg-white/5"></div>

                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/15 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-white/90">
                            E-7anuta Access
                        </a>

                        <h1 class="mt-7 font-display text-4xl font-bold leading-tight sm:text-5xl">
                            Your Storefront
                            <span class="block text-brand-300">Control Center</span>
                        </h1>

                        <p class="mt-5 max-w-md text-base leading-relaxed text-shop-gray-200 sm:text-lg">
                            Sign in to manage your marketplace from one place.
                        </p>
                    </section>

                    <section class="login-enter-right rounded-[2rem] border border-shop-gray-200/80 bg-white/95 p-7 shadow-[0_30px_90px_-32px_rgba(15,23,42,0.65)] backdrop-blur-sm sm:p-10">
                        <p class="inline-flex items-center rounded-full bg-shop-gray-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-shop-gray-700">
                            Log in
                        </p>
                        <h2 class="mt-4 font-display text-3xl font-bold text-shop-gray-950 sm:text-4xl">Welcome back</h2>
                        <p class="mt-2 text-sm text-shop-gray-700">
                            Enter your credentials to access your account.
                        </p>

                        <x-auth-session-status class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                            @csrf

                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-shop-gray-800" />
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="mt-1.5 block w-full rounded-xl border-shop-gray-200 bg-white px-4 py-3 text-sm text-shop-gray-900 shadow-sm transition focus:border-brand-500 focus:ring-brand-500"
                                >
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-shop-gray-800" />
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="mt-1.5 block w-full rounded-xl border-shop-gray-200 bg-white px-4 py-3 text-sm text-shop-gray-900 shadow-sm transition focus:border-brand-500 focus:ring-brand-500"
                                >
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-shop-gray-900 to-shop-gray-800 px-5 py-3 text-sm font-semibold text-white shadow-soft transition hover:from-brand-700 hover:to-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2"
                            >
                                {{ __('Log in') }}
                            </button>
                        </form>

                        @if (Route::has('register'))
                            <p class="mt-6 text-center text-sm text-shop-gray-700">
                                New here?
                                <a href="{{ route('register') }}" class="font-semibold text-brand-700 transition hover:text-brand-800">
                                    {{ __('Create an account') }}
                                </a>
                            </p>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
