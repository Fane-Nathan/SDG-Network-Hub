@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="margin-bottom: 1rem;"><a href="{{ route('home') }}" style="color: #2563eb;">&larr; Back to opportunities</a></div>

        <div style="display: flex; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 260px;">
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $opportunity->title }}</h1>
                <p style="color: #475569; margin: 0 0 0.75rem;">Hosted by {{ $opportunity->owner->organization_name ?? $opportunity->owner->name }}</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <span class="badge">{{ ucfirst($opportunity->opportunity_type) }}</span>
                    <span class="badge" style="background-color: rgba(16, 185, 129, 0.15); color: #047857;">{{ $opportunity->sdg_focus ?? 'SDG 17' }}</span>
                    <span class="badge" style="background-color: rgba(37,99,235,0.15); color: #1d4ed8;">{{ ucfirst($opportunity->mode) }}</span>
                    <span class="badge" style="background-color: rgba(249, 115, 22, 0.12); color: #ea580c;">{{ ucfirst($opportunity->status) }}</span>
                </div>
            </div>
            <div style="min-width: 220px;">
                <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">Key details</h2>
                <ul style="margin: 0; padding-left: 1.1rem; color: #475569;">
                    <li>Location: {{ $opportunity->location_city ? $opportunity->location_city . ', ' : '' }}{{ $opportunity->location_country ?? 'Global' }}</li>
                    <li>Deadline: {{ optional($opportunity->deadline)->format('M d, Y') ?? 'Rolling' }}</li>
                    <li>Starts: {{ optional($opportunity->start_date)->format('M d, Y') ?? 'Flexible' }}</li>
                    <li>Ends: {{ optional($opportunity->end_date)->format('M d, Y') ?? 'Flexible' }}</li>
                    <li>Capacity: {{ $opportunity->capacity ?? 'Open' }}</li>
                </ul>
            </div>
        </div>

        @if ($opportunity->summary)
            <p style="margin-top: 1.5rem; font-size: 1.05rem; color: #0f172a;">{{ $opportunity->summary }}</p>
        @endif

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 1.5rem 0;">

        <div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.75rem;">Opportunity description</h2>
                <div style="color: #475569; line-height: 1.6;">
                    {!! nl2br(e($opportunity->description)) !!}
                </div>
            </div>
            <div style="background-color: #f8fafc; border-radius: 1rem; padding: 1.25rem; border: 1px solid #e2e8f0;">
                <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.75rem;">Host organisation</h3>
                <p style="margin: 0; color: #0f172a; font-weight: 600;">{{ $opportunity->owner->organization_name ?? $opportunity->owner->name }}</p>
                @if ($opportunity->owner->organization_type)
                    <p style="margin: 0; color: #475569;">{{ $opportunity->owner->organization_type }}</p>
                @endif
                @if ($opportunity->owner->website)
                    <p style="margin: 0.5rem 0 0;"><a href="{{ $opportunity->owner->website }}" target="_blank" rel="noopener" style="color: #2563eb;">{{ $opportunity->owner->website }}</a></p>
                @endif
                <p style="margin: 0.75rem 0 0; color: #475569;">SDG focus: {{ $opportunity->owner->focus_areas ?? 'Goal 17 partnerships' }}</p>
                <p style="margin: 0.75rem 0 0; color: #475569;">Contact: {{ $opportunity->contact_email ?? $opportunity->owner->email }}</p>
                @if ($opportunity->contact_phone)
                    <p style="margin: 0; color: #475569;">Phone: {{ $opportunity->contact_phone }}</p>
                @endif
            </div>
        </div>
    </div>

    @auth
        @if (auth()->user()->isIndividual())
            <div class="card" style="max-width: 760px; margin: 1.5rem auto 0;">
                <h2 style="font-size: 1.35rem; font-weight: 600; margin-bottom: 0.75rem;">Express your interest</h2>
                @if ($existingApplication)
                    <p style="color: #16a34a; font-weight: 600;">You&apos;ve already submitted an application. You can update your message below.</p>
                @endif
                @if (! $opportunity->isOpen())
                    <p style="color: #dc2626;">Applications are currently closed.</p>
                @else
                    <form method="POST" action="{{ route('applications.store', $opportunity) }}" style="display: grid; gap: 1rem;">
                        @csrf
                        <div>
                            <label for="message">Motivation &amp; relevant experience</label>
                            <textarea id="message" name="message" rows="6" required>{{ old('message', optional($existingApplication)->message) }}</textarea>
                            @error('message')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            @error('application')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn-primary" style="align-self: flex-start;">{{ $existingApplication ? 'Update application' : 'Submit application' }}</button>
                    </form>
                @endif
            </div>
        @endif

        @if (auth()->user()->isOrganization() && auth()->id() === $opportunity->user_id)
            <div class="card" style="margin-top: 1.5rem;">
                <h2 style="font-size: 1.35rem; font-weight: 600; margin-bottom: 1rem;">Applications received</h2>
                @if ($applications->isEmpty())
                    <p style="color: #475569;">No applications yet. Share the opportunity with your partners to reach potential collaborators.</p>
                @else
                    <div style="display: grid; gap: 1rem;">
                        @foreach ($applications as $application)
                            <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem;">
                                <h3 style="margin: 0 0 0.35rem; font-size: 1.1rem; font-weight: 600;">{{ $application->applicant->name }}</h3>
                                <p style="margin: 0; color: #475569;">Skills: {{ $application->applicant->skills ?? 'Not provided' }}</p>
                                <p style="margin: 0.5rem 0 0; color: #0f172a; white-space: pre-line;">{{ $application->message }}</p>
                                <p style="margin: 0.75rem 0 0; color: #64748b; font-size: 0.85rem;">Submitted {{ $application->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @else
        <div class="card" style="max-width: 760px; margin: 1.5rem auto 0; text-align: center;">
            <h2 style="font-size: 1.35rem; font-weight: 600; margin-bottom: 0.75rem;">Ready to participate?</h2>
            <p style="color: #475569; margin-bottom: 1.25rem;">Create a free account to apply or save this opportunity for your SDG portfolio.</p>
            <a href="{{ route('register') }}" class="btn-primary">Join SDG Network Hub</a>
        </div>
    @endauth
@endsection