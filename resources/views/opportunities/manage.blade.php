@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 700; margin: 0 0 0.3rem;">Manage opportunities</h1>
                <p style="color: #475569; margin: 0;">Track your SDG-focused postings and review incoming applications.</p>
            </div>
            <a href="{{ route('opportunities.create') }}" class="btn-primary">Create new</a>
        </div>
\n        @if ($opportunities->isEmpty())
            <p style="color: #475569;">You haven&apos;t posted any opportunities yet. Start by publishing a role or event aligned with SDG 17.</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f1f5f9; text-align: left;">
                            <th style="padding: 0.75rem;">Title</th>
                            <th style="padding: 0.75rem;">Type</th>
                            <th style="padding: 0.75rem;">Status</th>
                            <th style="padding: 0.75rem;">Mode</th>
                            <th style="padding: 0.75rem;">Deadline</th>
                            <th style="padding: 0.75rem;">Applicants</th>
                            <th style="padding: 0.75rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opportunities as $opportunity)
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 0.75rem; font-weight: 600;">
                                    <a href="{{ route('opportunities.show', $opportunity) }}" style="color: #2563eb; text-decoration: none;">{{ $opportunity->title }}</a>
                                </td>
                                <td style="padding: 0.75rem;">{{ ucfirst($opportunity->opportunity_type) }}</td>
                                <td style="padding: 0.75rem;">
                                    <span class="badge" style="background-color: rgba(37,99,235,0.1); color: #1d4ed8;">{{ ucfirst($opportunity->status) }}</span>
                                </td>
                                <td style="padding: 0.75rem;">{{ ucfirst($opportunity->mode) }}</td>
                                <td style="padding: 0.75rem;">{{ optional($opportunity->deadline)->format('M d, Y') ?? 'â€”' }}</td>
                                <td style="padding: 0.75rem;">{{ $opportunity->applications_count }}</td>
                                <td style="padding: 0.75rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn-secondary">Edit</a>
                                    <form method="POST" action="{{ route('opportunities.destroy', $opportunity) }}" onsubmit="return confirm('Delete this opportunity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary" style="border-color: #dc2626; color: #dc2626;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1rem;">
                {{ $opportunities->links() }}
            </div>
        @endif
    </div>
@endsection