@extends('layouts.app')

@section('content')
    <div class="animate-fade-in-up" style="max-width: 480px; margin: 4rem auto;">
        <div class="text-center mb-10">
            <h1 class="headline mb-4" style="font-size: 2.5rem;">Welcome back</h1>
            <p class="muted-copy">Sign in to manage opportunities or track the SDG collaborations you follow.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="grid gap-6">
            @csrf

            <div>
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required class="form-input">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                <label for="remember" class="text-sm font-medium text-slate-600 cursor-pointer select-none">Remember me</label>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3 text-lg">Sign in</button>
        </form>

        <p class="text-center mt-8 text-slate-500">
            New here? <a href="{{ route('register') }}" class="font-semibold text-slate-900 hover:underline">Create an account</a>
        </p>
    </div>
@endsection
