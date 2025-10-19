@extends('layouts.app')

@section('content')
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1 style="font-size: 1.75rem; font-weight: 700; margin: 0 0 0.5rem;">Welcome, {{ $user->name }}!</h1>
                    <p style="color: #475569; margin: 0;">You're collaborating as <span class="badge">{{ ucfirst($user->role) }}</span>.</p>
                </div>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    @if ($user->isOrganization())
                        <a href="{{ route('opportunities.create') }}" class="btn-primary">Post opportunity</a>
                        <a href="{{ route('opportunities.manage') }}" class="btn-secondary">Manage postings</a>
                    @else
                        <a href="{{ route('applications.mine') }}" class="btn-secondary">My applications</a>
                        <a href="{{ route('home') }}" class="btn-primary">Browse opportunities</a>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
            @foreach ($metrics as $label => $value)
                <div class="card" style="text-align: center; margin: 0;">
                    <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.75rem; color: #64748b; margin-bottom: 0.35rem;">{{ str_replace('_', ' ', $label) }}</p>
                    <p style="font-size: 2rem; font-weight: 700; color: #1d4ed8; margin: 0;">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        @if ($user->isOrganization())
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="font-size: 1.3rem; font-weight: 600;">Recent opportunities</h2>
                    <a href="{{ route('opportunities.manage') }}" style="color: #2563eb; font-weight: 600;">View all</a>
                </div>
                @if ($recentOpportunities->isEmpty())
                    <p style="color: #475569;">No opportunities yet. Publish your first post to reach SDG partners.</p>
                @else
                    <div style="display: grid; gap: 1rem;">
                        @foreach ($recentOpportunities as $opportunity)
                            <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; display: flex; justify-content: space-between; gap: 1.25rem; flex-wrap: wrap;">
                                <div>
                                    <h3 style="margin: 0 0 0.35rem; font-size: 1.1rem; font-weight: 600;">{{ $opportunity->title }}</h3>
                                    <p style="margin: 0; color: #475569;">{{ $opportunity->opportunity_type }} • {{ $opportunity->mode }}</p>
                                    <p style="margin: 0.5rem 0 0; color: #0f172a;">Applications: <strong>{{ $opportunity->applications_count }}</strong></p>
                                </div>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn-secondary">Edit</a>
                                    <a href="{{ route('opportunities.show', $opportunity) }}" class="btn-primary">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="font-size: 1.3rem; font-weight: 600;">Latest applications</h2>
                    <a href="{{ route('applications.mine') }}" style="color: #2563eb; font-weight: 600;">View all</a>
                </div>
                @if ($recentApplications->isEmpty())
                    <p style="color: #475569;">You haven&apos;t applied to any opportunities yet. Explore the hub and submit your first application.</p>
                @else
                    <div style="display: grid; gap: 1rem;">
                        @foreach ($recentApplications as $application)
                            <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem;">
                                <h3 style="margin: 0 0 0.35rem; font-size: 1.1rem; font-weight: 600;">
                                    <a href="{{ route('opportunities.show', $application->opportunity) }}" style="color: #0f172a; text-decoration: none;">{{ $application->opportunity->title }}</a>
                                </h3>
                                <p style="margin: 0; color: #475569;">Status: <strong>{{ ucfirst($application->status) }}</strong></p>
                                <p style="margin: 0.5rem 0 0; color: #64748b; font-size: 0.9rem;">Submitted {{ $application->created_at->diffForHumans() }} • Host: {{ $application->opportunity->owner->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection