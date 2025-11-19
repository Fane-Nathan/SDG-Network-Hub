@extends('layouts.app')

@section('content')
    <div class="card max-w-4xl mx-auto">
        <h1 class="headline" style="font-size: 1.75rem; margin-bottom: 1rem;">{{ $title }}</h1>
        <p class="muted-copy mb-6">Share opportunities that strengthen Goal 17 partnerships. Include clear expectations and SDG focus so individuals can respond thoughtfully.</p>

        <form method="POST" action="{{ $action }}" class="grid gap-5">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <label for="title" class="form-label">Opportunity title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $opportunity->title) }}" required class="form-input">
                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="summary" class="form-label">Short summary</label>
                <input type="text" id="summary" name="summary" value="{{ old('summary', $opportunity->summary) }}" placeholder="One sentence overview (optional)" class="form-input">
                @error('summary')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div>
                    <label for="opportunity_type" class="form-label">Type</label>
                    <select id="opportunity_type" name="opportunity_type" required class="form-select">
                        <option value="">Select</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ old('opportunity_type', $opportunity->opportunity_type) === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('opportunity_type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="mode" class="form-label">Mode</label>
                    <select id="mode" name="mode" required class="form-select">
                        <option value="">Select</option>
                        @foreach ($modes as $mode)
                            <option value="{{ $mode }}" {{ old('mode', $opportunity->mode) === $mode ? 'selected' : '' }}>{{ ucfirst($mode) }}</option>
                        @endforeach
                    </select>
                    @error('mode')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" required class="form-select">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ old('status', $opportunity->status ?? 'open') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div>
                    <label for="sdg_focus" class="form-label">Primary SDG focus</label>
                    <input type="text" id="sdg_focus" name="sdg_focus" value="{{ old('sdg_focus', $opportunity->sdg_focus) }}" placeholder="e.g., SDG 17, SDG 5" class="form-input">
                    @error('sdg_focus')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="location_country" class="form-label">Country</label>
                    <input type="text" id="location_country" name="location_country" value="{{ old('location_country', $opportunity->location_country) }}" class="form-input">
                    @error('location_country')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="location_city" class="form-label">City / region</label>
                    <input type="text" id="location_city" name="location_city" value="{{ old('location_city', $opportunity->location_city) }}" class="form-input">
                    @error('location_city')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-4">
                <div>
                    <label for="start_date" class="form-label">Start date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', optional($opportunity->start_date)->format('Y-m-d')) }}" class="form-input">
                    @error('start_date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="form-label">End date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', optional($opportunity->end_date)->format('Y-m-d')) }}" class="form-input">
                    @error('end_date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="deadline" class="form-label">Application deadline</label>
                    <input type="date" id="deadline" name="deadline" value="{{ old('deadline', optional($opportunity->deadline)->format('Y-m-d')) }}" class="form-input">
                    @error('deadline')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $opportunity->capacity) }}" min="1" placeholder="Number of slots" class="form-input">
                    @error('capacity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="contact_email" class="form-label">Contact email</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $opportunity->contact_email ?? auth()->user()->email) }}" class="form-input">
                    @error('contact_email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="contact_phone" class="form-label">Contact phone</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $opportunity->contact_phone) }}" class="form-input">
                    @error('contact_phone')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="form-label">Full description</label>
                <textarea id="description" name="description" rows="8" required class="form-textarea">{{ old('description', $opportunity->description) }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 flex-wrap">
                <button type="submit" class="btn-primary">Save opportunity</button>
                <a href="{{ route('opportunities.manage') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection