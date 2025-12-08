@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="headline" style="font-size: 1.6rem; margin-bottom: 0.35rem;">My applications</h1>
                <p class="muted-copy">Track every opportunity you&apos;ve responded to across the SDG Network Hub.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-secondary">Find new opportunities</a>
        </div>

        @if ($applications->isEmpty())
            <p class="muted-copy">You haven&apos;t applied to any opportunities yet. Browse the hub and join a partnership that matches your skills.</p>
        @else
            <div class="grid gap-4">
                @foreach ($applications as $application)
                    <div class="border border-slate-200 rounded-xl p-4">
                        <div class="flex flex-wrap justify-between gap-4 mb-3">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900 mb-1">
                                    <a href="{{ route('opportunities.show', $application->opportunity) }}" class="hover:underline">{{ $application->opportunity->title }}</a>
                                </h2>
                                <p class="text-slate-600">Hosted by {{ $application->opportunity->owner->organization_name ?? $application->opportunity->owner->name }}</p>
                                <p class="mt-2 text-sm text-slate-500">Submitted {{ $application->created_at->format('M d, Y') }} • Status: <strong>{{ ucfirst($application->status) }}</strong></p>
                            </div>
                            <a href="{{ route('opportunities.show', $application->opportunity) }}" class="btn-primary self-start">View opportunity</a>
                            <form method="POST" action="{{ route('applications.destroy', $application) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-secondary text-sm" onclick="return confirm('Are you sure?')">Withdraw</button>
                            </form>
                        </div>
                        <div class="text-slate-600 whitespace-pre-line">{{ $application->message }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection