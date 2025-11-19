@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('content')
    <section class="hero-card">
        <div class="hero-content">
            <span class="hero-badge">The SDG Network</span>
            <h1 class="hero-title">We build partnerships for global goals.</h1>
            <p class="hero-copy">
                A curated collective of {{ number_format($opportunities->total()) }} initiatives driving sustainable development across {{ $opportunities->count() > 0 ? '140+' : 'global' }} regions.
            </p>
            <div class="hero-actions">
                <a href="#work" class="btn-primary">View Projects</a>
                @auth
                    @if (auth()->user()->isOrganization())
                        <a href="{{ route('opportunities.create') }}" class="btn-secondary">Submit Work</a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-secondary">Join Collective</a>
                @endauth
            </div>
        </div>
    </section>

    <section id="work" class="filter-panel" style="margin-top: 4rem; margin-bottom: 2rem;">
        <div class="results-meta">
            <h2 class="headline" style="font-size: 2rem;">Selected Work</h2>
        </div>
        <form method="GET" action="{{ route('home') }}" class="filter-grid">
            <div class="form-group">
                <label for="search" class="form-label">Keyword</label>
                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by initiative, host, or theme" class="form-input">
            </div>
            <div class="form-group">
                <label for="sdg" class="form-label">SDG focus</label>
                <input type="text" id="sdg" name="sdg" value="{{ $filters['sdg'] ?? '' }}" placeholder="e.g., SDG 5 or Gender" class="form-input">
            </div>
            <div class="form-group">
                <label for="location" class="form-label">Location</label>
                <input type="text" id="location" name="location" value="{{ $filters['location'] ?? '' }}" placeholder="Country, city, or region" class="form-input">
            </div>
            <div class="form-group">
                <label for="type" class="form-label">Opportunity type</label>
                <select id="type" name="type" class="form-select">
                    <option value="">Any</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="mode" class="form-label">Mode</label>
                <select id="mode" name="mode" class="form-select">
                    <option value="">Any</option>
                    @foreach ($modes as $mode)
                        <option value="{{ $mode }}" {{ ($filters['mode'] ?? '') === $mode ? 'selected' : '' }}>{{ ucfirst($mode) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group flex items-end">
                <button type="submit" class="btn-primary w-full">Filter results</button>
            </div>
        </form>
    </section>

    @if ($opportunities->isEmpty())
        <section class="card card--elevated empty-state">
            <div class="empty-state__icon">🌍</div>
            <div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">No matches just yet</h3>
                <p class="m-0">Try broadening your filters or check back soon—new partnerships arrive every week.</p>
            </div>
        </section>
    @else
        <section class="opportunity-grid">
            @foreach ($opportunities as $opportunity)
                <article class="opportunity-card">
                    <div class="opportunity-head">
                        <div class="opportunity-info">
                            <span class="text-sm font-bold tracking-wider text-gray-500 uppercase">{{ $opportunity->sdg_focus ?? 'Global' }}</span>
                            <h2 class="opportunity-title">
                                <a href="{{ route('opportunities.show', $opportunity) }}" class="hover:text-gray-600 transition-colors">{{ $opportunity->title }}</a>
                            </h2>
                            <div class="opportunity-details" style="font-size: 1.1rem; margin-top: 0.5rem;">
                                {{ $opportunity->summary ?? Str::limit(strip_tags($opportunity->description), 120) }}
                            </div>
                            <div class="mt-4 flex items-center gap-4 text-sm text-gray-500">
                                <span class="font-semibold text-gray-900">{{ $opportunity->owner->organization_name ?? $opportunity->owner->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $opportunity->location_city ? $opportunity->location_city . ', ' : '' }}{{ $opportunity->location_country ?? 'Remote' }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="mt-8 flex justify-center">
            {{ $opportunities->links() }}
        </div>
    @endif
@endsection
