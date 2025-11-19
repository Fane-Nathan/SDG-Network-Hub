@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="headline" style="font-size: 1.75rem; margin-bottom: 0.5rem;">Welcome, {{ $user->name }}!</h1>
                    <p class="muted-copy">You're collaborating as <span class="badge">{{ ucfirst($user->role) }}</span>.</p>
                </div>
                <div class="flex flex-wrap gap-3">
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

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($metrics as $label => $value)
                <div class="card text-center">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">{{ str_replace('_', ' ', $label) }}</p>
                    <p class="text-3xl font-bold text-blue-700">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        @if ($user->isOrganization())
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-slate-900">Recent opportunities</h2>
                    <a href="{{ route('opportunities.manage') }}" class="font-semibold text-blue-600 hover:text-blue-800">View all</a>
                </div>
                @if ($recentOpportunities->isEmpty())
                    <p class="muted-copy">No opportunities yet. Publish your first post to reach SDG partners.</p>
                @else
                    <div class="grid gap-4">
                        @foreach ($recentOpportunities as $opportunity)
                            <div class="flex flex-wrap items-center justify-between gap-5 rounded-xl border border-slate-200 p-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $opportunity->title }}</h3>
                                    <p class="text-slate-500">{{ $opportunity->opportunity_type }} • {{ $opportunity->mode }}</p>
                                    <p class="mt-2 text-slate-900">Applications: <strong>{{ $opportunity->applications_count }}</strong></p>
                                </div>
                                <div class="flex items-center gap-2">
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
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-slate-900">Latest applications</h2>
                    <a href="{{ route('applications.mine') }}" class="font-semibold text-blue-600 hover:text-blue-800">View all</a>
                </div>
                @if ($recentApplications->isEmpty())
                    <p class="muted-copy">You haven&apos;t applied to any opportunities yet. Explore the hub and submit your first application.</p>
                @else
                    <div class="grid gap-4">
                        @foreach ($recentApplications as $application)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">
                                    <a href="{{ route('opportunities.show', $application->opportunity) }}" class="hover:underline">{{ $application->opportunity->title }}</a>
                                </h3>
                                <p class="text-slate-500">Status: <strong>{{ ucfirst($application->status) }}</strong></p>
                                <p class="mt-2 text-sm text-slate-500">Submitted {{ $application->created_at->diffForHumans() }} • Host: {{ $application->opportunity->owner->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection