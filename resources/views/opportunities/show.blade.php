@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="mb-4">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">&larr; Back to opportunities</a>
        </div>

        <div class="flex flex-wrap justify-between gap-6">
            <div class="flex-1 min-w-[260px]">
                <h1 class="headline" style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $opportunity->title }}</h1>
                <p class="muted-copy mb-3">Hosted by {{ $opportunity->owner->organization_name ?? $opportunity->owner->name }}</p>
                <div class="flex flex-wrap gap-2">
                    <span class="badge">{{ ucfirst($opportunity->opportunity_type) }}</span>
                    <span class="badge bg-emerald-50 text-emerald-700">{{ $opportunity->sdg_focus ?? 'SDG 17' }}</span>
                    <span class="badge bg-blue-50 text-blue-700">{{ ucfirst($opportunity->mode) }}</span>
                    <span class="badge bg-orange-50 text-orange-600">{{ ucfirst($opportunity->status) }}</span>
                </div>
            </div>
            <div class="min-w-[220px]">
                <h2 class="text-lg font-semibold mb-2 text-slate-900">Key details</h2>
                <ul class="list-disc pl-5 text-slate-600 space-y-1">
                    <li>Location: {{ $opportunity->location_city ? $opportunity->location_city . ', ' : '' }}{{ $opportunity->location_country ?? 'Global' }}</li>
                    <li>Deadline: {{ optional($opportunity->deadline)->format('M d, Y') ?? 'Rolling' }}</li>
                    <li>Starts: {{ optional($opportunity->start_date)->format('M d, Y') ?? 'Flexible' }}</li>
                    <li>Ends: {{ optional($opportunity->end_date)->format('M d, Y') ?? 'Flexible' }}</li>
                    <li>Capacity: {{ $opportunity->capacity ?? 'Open' }}</li>
                </ul>
            </div>
        </div>

        @if ($opportunity->summary)
            <p class="mt-6 text-lg text-slate-900">{{ $opportunity->summary }}</p>
        @endif

        <hr class="my-6 border-t border-slate-200">

        <div class="grid gap-6 md:grid-cols-[1fr_300px]">
            <div>
                <h2 class="text-xl font-semibold mb-3 text-slate-900">Opportunity description</h2>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($opportunity->description)) !!}
                </div>
            </div>
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 h-fit">
                <h3 class="text-lg font-semibold mb-3 text-slate-900">Host organisation</h3>
                <p class="font-semibold text-slate-900">{{ $opportunity->owner->organization_name ?? $opportunity->owner->name }}</p>
                @if ($opportunity->owner->organization_type)
                    <p class="text-slate-600">{{ $opportunity->owner->organization_type }}</p>
                @endif
                @if ($opportunity->owner->website)
                    <p class="mt-2"><a href="{{ $opportunity->owner->website }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline break-all">{{ $opportunity->owner->website }}</a></p>
                @endif
                <p class="mt-3 text-slate-600">SDG focus: {{ $opportunity->owner->focus_areas ?? 'Goal 17 partnerships' }}</p>
                <p class="mt-3 text-slate-600">Contact: {{ $opportunity->contact_email ?? $opportunity->owner->email }}</p>
                @if ($opportunity->contact_phone)
                    <p class="text-slate-600">Phone: {{ $opportunity->contact_phone }}</p>
                @endif
            </div>
        </div>
    </div>

    @auth
        @if (auth()->user()->isIndividual())
            <div class="card max-w-3xl mx-auto mt-6">
                <h2 class="text-xl font-semibold mb-3 text-slate-900">Express your interest</h2>
                @if ($existingApplication)
                    <p class="text-green-600 font-semibold mb-4">You&apos;ve already submitted an application. You can update your message below.</p>
                @endif
                @if (! $opportunity->isOpen())
                    <p class="text-red-600 font-semibold">Applications are currently closed.</p>
                @else
                    <form method="POST" action="{{ route('applications.store', $opportunity) }}" class="grid gap-4">
                        @csrf
                        <div>
                            <label for="message" class="form-label">Motivation &amp; relevant experience</label>
                            <textarea id="message" name="message" rows="6" required class="form-textarea">{{ old('message', optional($existingApplication)->message) }}</textarea>
                            @error('message') <p class="error-message">{{ $message }}</p> @enderror
                            @error('application') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn-primary">{{ $existingApplication ? 'Update application' : 'Submit application' }}</button>
                        </div>
                    </form>

                    @if ($existingApplication)
                        <form method="POST" action="{{ route('applications.destroy', $existingApplication) }}" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary" onclick="return confirm('Are you sure you want to withdraw your application?')">Withdraw application</button>
                        </form>
                    @endif
                @endif
            </div>
        @endif

        @if (auth()->user()->isOrganization() && auth()->id() === $opportunity->user_id)
            <div class="card mt-6">
                <h2 class="text-xl font-semibold mb-4 text-slate-900">Applications received</h2>
                @if ($applications->isEmpty())
                    <p class="muted-copy">No applications yet. Share the opportunity with your partners to reach potential collaborators.</p>
                @else
                    <div class="grid gap-4">
                        @foreach ($applications as $application)
                            <div class="border border-slate-200 rounded-xl p-4">
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $application->applicant->name }}</h3>
                                <p class="text-slate-600">Skills: {{ $application->applicant->skills ?? 'Not provided' }}</p>
                                <p class="mt-2 text-slate-900 whitespace-pre-line">{{ $application->message }}</p>
                                <p class="mt-3 text-sm text-slate-500">Submitted {{ $application->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @else
        <div class="card max-w-3xl mx-auto mt-6 text-center">
            <h2 class="text-xl font-semibold mb-3 text-slate-900">Ready to participate?</h2>
            <p class="muted-copy mb-5">Create a free account to apply or save this opportunity for your SDG portfolio.</p>
            <a href="{{ route('register') }}" class="btn-primary inline-flex">Join SDG Network Hub</a>
        </div>
    @endauth
@endsection