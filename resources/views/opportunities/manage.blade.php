@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="headline" style="font-size: 1.6rem; margin-bottom: 0.3rem;">Manage opportunities</h1>
                <p class="muted-copy">Track your SDG-focused postings and review incoming applications.</p>
            </div>
            <a href="{{ route('opportunities.create') }}" class="btn-primary">Create new</a>
        </div>

        @if ($opportunities->isEmpty())
            <p class="muted-copy">You haven&apos;t posted any opportunities yet. Start by publishing a role or event aligned with SDG 17.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-900 font-semibold">
                        <tr>
                            <th class="p-3">Title</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Mode</th>
                            <th class="p-3">Deadline</th>
                            <th class="p-3">Applicants</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($opportunities as $opportunity)
                            <tr>
                                <td class="p-3 font-semibold text-slate-900">
                                    <a href="{{ route('opportunities.show', $opportunity) }}" class="text-blue-600 hover:underline">{{ $opportunity->title }}</a>
                                </td>
                                <td class="p-3">{{ ucfirst($opportunity->opportunity_type) }}</td>
                                <td class="p-3">
                                    <span class="badge bg-blue-50 text-blue-700">{{ ucfirst($opportunity->status) }}</span>
                                </td>
                                <td class="p-3">{{ ucfirst($opportunity->mode) }}</td>
                                <td class="p-3">{{ optional($opportunity->deadline)->format('M d, Y') ?? '—' }}</td>
                                <td class="p-3">{{ $opportunity->applications_count }}</td>
                                <td class="p-3 flex flex-wrap gap-2">
                                    <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn-secondary text-xs py-1 px-3">Edit</a>
                                    <form method="POST" action="{{ route('opportunities.destroy', $opportunity) }}" onsubmit="return confirm('Delete this opportunity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary text-xs py-1 px-3 border-red-200 text-red-600 hover:bg-red-50">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $opportunities->links() }}
            </div>
        @endif
    </div>
@endsection