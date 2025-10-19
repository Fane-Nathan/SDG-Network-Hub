@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 700; margin: 0 0 0.35rem;">My applications</h1>
                <p style="color: #475569; margin: 0;">Track every opportunity you&apos;ve responded to across the SDG Network Hub.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-secondary">Find new opportunities</a>
        </div>
\n        @if ($applications->isEmpty())
            <p style="color: #475569;">You haven&apos;t applied to any opportunities yet. Browse the hub and join a partnership that matches your skills.</p>
        @else
            <div style="display: grid; gap: 1rem;">
                @foreach ($applications as $application)
                    <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem;">
                        <div style="display: flex; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                            <div>
                                <h2 style="margin: 0 0 0.35rem; font-size: 1.2rem; font-weight: 600;">
                                    <a href="{{ route('opportunities.show', $application->opportunity) }}" style="color: #0f172a; text-decoration: none;">{{ $application->opportunity->title }}</a>
                                </h2>
                                <p style="margin: 0; color: #475569;">Hosted by {{ $application->opportunity->owner->organization_name ?? $application->opportunity->owner->name }}</p>
                                <p style="margin: 0.5rem 0 0; color: #64748b; font-size: 0.9rem;">Submitted {{ $application->created_at->format('M d, Y') }} â€¢ Status: <strong>{{ ucfirst($application->status) }}</strong></p>
                            </div>
                            <a href="{{ route('opportunities.show', $application->opportunity) }}" class="btn-primary">View opportunity</a>
                        </div>
                        <div style="margin-top: 0.75rem; color: #475569; white-space: pre-line;">{{ $application->message }}</div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 1.25rem;">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection