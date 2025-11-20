@extends('layouts.app')

@section('content')
    <div class="animate-fade-in-up" style="max-width: 600px; margin: 4rem auto;">
        <div class="text-center mb-10">
            <h1 class="headline mb-4" style="font-size: 2.5rem;">Join the Collective</h1>
            <p class="muted-copy">Create an account to publish opportunities, discover events, and build Goal 17 partnerships.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registration-form" class="grid gap-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="form-label">Your name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="form-input">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="role" class="form-label">Account type</label>
                <select id="role" name="role" required class="form-select">
                    <option value="">Select a role…</option>
                    <option value="organization" {{ old('role') === 'organization' ? 'selected' : '' }}>Organization – publish opportunities</option>
                    <option value="individual" {{ old('role') === 'individual' ? 'selected' : '' }}>Individual – explore and apply</option>
                </select>
                @error('role')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div id="organization-fields" style="display: none;" class="space-y-6 border-l-2 border-slate-200 pl-6 my-2">
                <div>
                    <label for="organization_name" class="form-label">Organization name</label>
                    <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name') }}" class="form-input">
                    @error('organization_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="organization_type" class="form-label">Organization type</label>
                        <input id="organization_type" type="text" name="organization_type" value="{{ old('organization_type') }}" placeholder="e.g., NGO, Gov" class="form-input">
                        @error('organization_type')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="website" class="form-label">Website</label>
                        <input id="website" type="text" name="website" value="{{ old('website') }}" placeholder="https://example.org" class="form-input">
                        @error('website')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="contact_phone" class="form-label">Primary contact phone</label>
                    <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="form-input">
                    @error('contact_phone')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="individual-fields" style="display: none;" class="space-y-6 border-l-2 border-slate-200 pl-6 my-2">
                <div>
                    <label for="skills" class="form-label">Key skills / expertise</label>
                    <input id="skills" type="text" name="skills" value="{{ old('skills') }}" placeholder="e.g., Facilitation, Policy Analysis" class="form-input">
                    @error('skills')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="location_country" class="form-label">Country</label>
                    <input id="location_country" type="text" name="location_country" value="{{ old('location_country') }}" class="form-input">
                    @error('location_country')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location_city" class="form-label">City / Region</label>
                    <input id="location_city" type="text" name="location_city" value="{{ old('location_city') }}" class="form-input">
                    @error('location_city')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="focus_areas" class="form-label">SDG focus areas</label>
                <input id="focus_areas" type="text" name="focus_areas" value="{{ old('focus_areas') }}" placeholder="e.g., SDG 5, SDG 8" class="form-input">
                @error('focus_areas')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="bio" class="form-label">Summary / mission</label>
                <textarea id="bio" name="bio" rows="3" class="form-textarea">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required class="form-input">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input">
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="btn-primary py-3 px-8 text-lg">Create account</button>
                <p class="text-slate-500">Already part of the hub? <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">Sign in</a></p>
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
