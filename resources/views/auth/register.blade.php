@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1.25rem;">Join the SDG Network Hub</h1>
        <p style="margin-bottom: 1.5rem; color: #475569;">Create an account to publish opportunities, discover events, and build Goal 17 partnerships.</p>

        <form method="POST" action="{{ route('register') }}" id="registration-form">
            @csrf

            <div class="form-group">
                <label for="name">Your name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Account type</label>
                <select id="role" name="role" required>
                    <option value="">Select a role…</option>
                    <option value="organization" {{ old('role') === 'organization' ? 'selected' : '' }}>Organization – publish opportunities</option>
                    <option value="individual" {{ old('role') === 'individual' ? 'selected' : '' }}>Individual – explore and apply</option>
                </select>
                @error('role')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div id="organization-fields" style="display: none;">
                <div class="form-group">
                    <label for="organization_name">Organization name</label>
                    <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name') }}">
                    @error('organization_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="organization_type">Organization type</label>
                    <input id="organization_type" type="text" name="organization_type" value="{{ old('organization_type') }}" placeholder="e.g., NGO, Government Agency">
                    @error('organization_type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <input id="website" type="text" name="website" value="{{ old('website') }}" placeholder="https://example.org">
                    @error('website')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="contact_phone">Primary contact phone</label>
                    <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone') }}">
                    @error('contact_phone')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="individual-fields" style="display: none;">
                <div class="form-group">
                    <label for="skills">Key skills / expertise</label>
                    <input id="skills" type="text" name="skills" value="{{ old('skills') }}" placeholder="e.g., Facilitation, Policy Analysis">
                    @error('skills')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="location_country">Country</label>
                <input id="location_country" type="text" name="location_country" value="{{ old('location_country') }}">
                @error('location_country')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="location_city">City / Region</label>
                <input id="location_city" type="text" name="location_city" value="{{ old('location_city') }}">
                @error('location_city')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="focus_areas">SDG focus areas</label>
                <input id="focus_areas" type="text" name="focus_areas" value="{{ old('focus_areas') }}" placeholder="e.g., SDG 5, SDG 8">
                @error('focus_areas')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio">Summary / mission</label>
                <textarea id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-primary">Create account</button>
                <p style="margin: 0;">Already part of the hub? <a href="{{ route('login') }}" style="color: #2563eb; font-weight: 600;">Sign in</a></p>
            </div>
        </form>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const orgFields = document.getElementById('organization-fields');
        const individualFields = document.getElementById('individual-fields');

        function toggleRoleBlocks() {
            const role = roleSelect.value;
            orgFields.style.display = role === 'organization' ? 'block' : 'none';
            individualFields.style.display = role === 'individual' ? 'block' : 'none';
        }

        roleSelect.addEventListener('change', toggleRoleBlocks);
        toggleRoleBlocks();
    </script>
@endsection
