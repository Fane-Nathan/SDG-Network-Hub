@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@push('styles')
    <style>
        .hero-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(76, 111, 255, 0.92), rgba(157, 75, 255, 0.88));
            color: #fff;
            padding: clamp(2.25rem, 6vw, 3.4rem);
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1.5rem;
        }

        .hero-card::before,
        .hero-card::after {
            content: '';
            position: absolute;
            border-radius: 9999px;
            filter: blur(0px);
        }

        .hero-card::before {
            width: 420px;
            height: 420px;
            top: -220px;
            right: -180px;
            background: radial-gradient(circle, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0) 70%);
        }

        .hero-card::after {
            width: 260px;
            height: 260px;
            bottom: -180px;
            left: -120px;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.45) 0%, rgba(34, 211, 238, 0) 70%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 1.25rem;
            max-width: 640px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.1rem;
            border-radius: 9999px;
            background: rgba(15, 23, 42, 0.18);
            backdrop-filter: blur(12px);
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: clamp(2.2rem, 5.5vw, 3.1rem);
            line-height: 1.12;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .hero-copy {
            margin: 0;
            font-size: 1.05rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.92);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 0.75rem;
        }

        .hero-stat {
            background: rgba(16, 24, 40, 0.22);
            padding: 0.9rem 1rem;
            border-radius: 1rem;
            backdrop-filter: blur(12px);
        }

        .hero-stat strong {
            display: block;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .filter-panel {
            display: grid;
            gap: 1.5rem;
        }

        .filter-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .filter-grid .form-group {
            margin-bottom: 0;
        }

        .results-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(15, 23, 42, 0.65);
            background: rgba(148, 163, 184, 0.16);
        }

        .opportunity-grid {
            display: grid;
            gap: 1.5rem;
        }

        .opportunity-card {
            position: relative;
            overflow: hidden;
        }

        .opportunity-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(120% 160% at 100% 0%, rgba(76, 111, 255, 0.18), transparent 65%);
            pointer-events: none;
        }

        .opportunity-head {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }

        .opportunity-info {
            display: grid;
            gap: 0.45rem;
            max-width: 680px;
        }

        .opportunity-title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
            color: #0b1b3a;
        }

        .opportunity-details {
            display: grid;
            gap: 0.35rem;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .tag-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
            position: relative;
            z-index: 1;
        }

        .tag-stack .badge:nth-child(2) {
            background: rgba(34, 197, 94, 0.18);
            color: #15803d;
        }

        .tag-stack .badge:nth-child(3) {
            background: rgba(14, 165, 233, 0.18);
            color: #0369a1;
        }

        .empty-state {
            text-align: center;
            padding: 2.5rem 2rem;
            color: var(--text-secondary);
            display: grid;
            gap: 1rem;
        }

        .empty-state__icon {
            width: 70px;
            height: 70px;
            margin: 0 auto;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(76, 111, 255, 0.18), rgba(157, 75, 255, 0.22));
            display: grid;
            place-items: center;
            font-size: 1.9rem;
        }

        @media (max-width: 640px) {
            .hero-card::before {
                top: -260px;
                right: -220px;
            }

            .hero-card::after {
                bottom: -220px;
                left: -150px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero-card card card--elevated">
        <div class="hero-content">
            <span class="hero-badge">Global SDG 17 Coalition</span>
            <h1 class="hero-title">Build partnerships that move the Sustainable Development Goals forward.</h1>
            <p class="hero-copy">
                Discover curated opportunities from NGOs, governments, and mission-driven organisations that are ready to collaborate. Filter by SDG, geography, or contribution type to match your talent with the partnerships that need it most.
            </p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-primary">Join the community</a>
                @auth
                    @if (auth()->user()->isOrganization())
                        <a href="{{ route('opportunities.create') }}" class="btn-secondary">Publish an opportunity</a>
                    @else
                        <a href="{{ route('applications.mine') }}" class="btn-secondary">Review my applications</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-ghost" style="color: rgba(255,255,255,0.8);">Already a member? Sign in</a>
                @endauth
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>{{ number_format($opportunities->total()) }}</strong>
                    Live partnerships
                </div>
                <div class="hero-stat">
                    <strong>17</strong>
                    SDGs represented
                </div>
                <div class="hero-stat">
                    <strong>140+</strong>
                    Countries & regions
                </div>
            </div>
        </div>
    </section>

    <section class="card card--elevated filter-panel">
        <div class="results-meta">
            <div>
                <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #0b1b3a;">Explore aligned opportunities</h2>
                <p style="margin: 0; font-size: 0.95rem; color: var(--text-secondary);">Refine by focus area, geography, or engagement style to surface the right partnership.</p>
            </div>
            <span class="pill">{{ $opportunities->total() }} opportunities</span>
        </div>
        <form method="GET" action="{{ route('home') }}" class="filter-grid">
            <div class="form-group">
                <label for="search">Keyword</label>
                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by initiative, host, or theme">
            </div>
            <div class="form-group">
                <label for="sdg">SDG focus</label>
                <input type="text" id="sdg" name="sdg" value="{{ $filters['sdg'] ?? '' }}" placeholder="e.g., SDG 5 or Gender">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="{{ $filters['location'] ?? '' }}" placeholder="Country, city, or region">
            </div>
            <div class="form-group">
                <label for="type">Opportunity type</label>
                <select id="type" name="type">
                    <option value="">Any</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="mode">Mode</label>
                <select id="mode" name="mode">
                    <option value="">Any</option>
                    @foreach ($modes as $mode)
                        <option value="{{ $mode }}" {{ ($filters['mode'] ?? '') === $mode ? 'selected' : '' }}>{{ ucfirst($mode) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="display: flex; align-items: flex-end;">
                <button type="submit" class="btn-primary" style="width: 100%;">Filter results</button>
            </div>
        </form>
    </section>

    @if ($opportunities->isEmpty())
        <section class="card card--elevated empty-state">
            <div class="empty-state__icon">🌍</div>
            <div>
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.2rem; font-weight: 700; color: #0b1b3a;">No matches just yet</h3>
                <p style="margin: 0;">Try broadening your filters or check back soon—new partnerships arrive every week.</p>
            </div>
        </section>
    @else
        <section class="opportunity-grid">
            @foreach ($opportunities as $opportunity)
                <article class="card opportunity-card">
                    <div class="opportunity-head">
                        <div class="opportunity-info">
                            <h2 class="opportunity-title">
                                <a href="{{ route('opportunities.show', $opportunity) }}">{{ $opportunity->title }}</a>
                            </h2>
                            <div class="opportunity-details">
                                <span>Hosted by <strong>{{ $opportunity->owner->organization_name ?? $opportunity->owner->name }}</strong></span>
                                <span>{{ $opportunity->summary ?? Str::limit(strip_tags($opportunity->description), 160) }}</span>
                            </div>
                        </div>
                        <div class="tag-stack">
                            <span class="badge">{{ ucfirst($opportunity->opportunity_type) }}</span>
                            <span class="badge">{{ $opportunity->sdg_focus ?? 'SDG 17' }}</span>
                            <span class="badge">{{ $opportunity->location_city ? $opportunity->location_city . ', ' : '' }}{{ $opportunity->location_country ?? 'Global' }}</span>
                            <span class="badge" style="background: rgba(76,111,255,0.18); color: var(--brand-primary);">{{ ucfirst($opportunity->mode) }}</span>
                            <span class="badge" style="background: rgba(248,113,113,0.18); color: #b91c1c;">
                                {{ $opportunity->deadline ? 'Apply by ' . $opportunity->deadline->format('M d, Y') : 'Rolling deadline' }}
                            </span>
                            <span class="badge" style="background: rgba(15,23,42,0.12); color: #0f172a;">{{ $opportunity->applications_count }} applicants</span>
                        </div>
                    </div>
                    <div style="margin-top: 1.35rem; display: flex; justify-content: flex-end; position: relative; z-index: 1;">
                        <a href="{{ route('opportunities.show', $opportunity) }}" class="btn-secondary">View opportunity</a>
                    </div>
                </article>
            @endforeach
        </section>

        <div style="margin-top: 1.75rem; display: flex; justify-content: center;">
            {{ $opportunities->links() }}
        </div>
    @endif
@endsection
