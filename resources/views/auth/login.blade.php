@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 520px; margin: 0 auto;">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1.25rem;">Welcome back</h1>
        <p style="margin-bottom: 1.5rem; color: #475569;">Sign in to manage opportunities or track the SDG collaborations you follow.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" style="margin: 0; font-weight: 500;">Remember me</label>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; text-align: center;">Sign in</button>
        </form>

        <p style="margin-top: 1.5rem; color: #475569;">New here? <a href="{{ route('register') }}" style="color: #2563eb; font-weight: 600;">Create an account</a></p>
    </div>
@endsection
