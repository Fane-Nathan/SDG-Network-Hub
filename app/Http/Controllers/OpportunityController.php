<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OpportunityController extends Controller
{
    private const TYPES = [
        'job',
        'volunteering',
        'event',
        'fellowship',
        'consultancy',
        'grant',
    ];

    private const MODES = ['onsite', 'remote', 'hybrid'];
    private const STATUSES = ['open', 'draft', 'closed'];

    public function publicIndex(Request $request): View
    {
        $filters = $request->only(['search', 'location', 'sdg', 'type', 'mode']);

        $opportunities = Opportunity::with('owner')
            ->withCount('applications')
            ->published()
            ->filter($filters)
            ->latest('published_at')
            ->latest('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('opportunities.public-index', [
            'filters' => $filters,
            'opportunities' => $opportunities,
            'types' => self::TYPES,
            'modes' => self::MODES,
        ]);
    }

    public function manage(Request $request): View
    {
        $this->ensureOrganization();

        $opportunities = $request->user()
            ->opportunities()
            ->withCount('applications')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('opportunities.manage', [
            'opportunities' => $opportunities,
            'types' => self::TYPES,
            'modes' => self::MODES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function create(): View
    {
        $this->ensureOrganization();

        return view('opportunities.form', [
            'opportunity' => new Opportunity(),
            'types' => self::TYPES,
            'modes' => self::MODES,
            'statuses' => self::STATUSES,
            'method' => 'POST',
            'action' => route('opportunities.store'),
            'title' => 'Post a new opportunity',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureOrganization();

        $data = $this->validatedData($request);
        if (empty($data['contact_email'])) {
            $data['contact_email'] = $request->user()->email;
        }
        $data['published_at'] = $data['status'] === 'open' ? now() : null;

        $opportunity = $request->user()->opportunities()->create($data);

        return redirect()
            ->route('opportunities.manage')
            ->with('status', 'Opportunity "' . $opportunity->title . '" created successfully.');
    }

    public function show(Request $request, Opportunity $opportunity): View
    {
        $applications = collect();
        $existingApplication = null;
        $user = $request->user();

        if ($user && $user->isOrganization() && $user->id === $opportunity->user_id) {
            $applications = $opportunity->applications()
                ->with('applicant')
                ->latest()
                ->get();
        } elseif ($user) {
            // Get user's existing application if they already applied
            $existingApplication = $opportunity->applications()
                ->where('user_id', $user->id)
                ->first();
        }

        return view('opportunities.show', [
            'opportunity' => $opportunity->load('owner'),
            'applications' => $applications,
            'existingApplication' => $existingApplication,
        ]);
    }

    public function edit(Opportunity $opportunity): View
    {
        $this->ensureOwnership($opportunity);

        return view('opportunities.form', [
            'opportunity' => $opportunity,
            'types' => self::TYPES,
            'modes' => self::MODES,
            'statuses' => self::STATUSES,
            'method' => 'PUT',
            'action' => route('opportunities.update', $opportunity),
            'title' => 'Update opportunity',
        ]);
    }

    public function update(Request $request, Opportunity $opportunity): RedirectResponse
    {
        $this->ensureOwnership($opportunity);

        $data = $this->validatedData($request, $opportunity);
        if (empty($data['contact_email'])) {
            $data['contact_email'] = $request->user()->email;
        }
        $data['published_at'] = $data['status'] === 'open'
            ? ($opportunity->published_at ?? now())
            : null;

        $opportunity->update($data);

        return redirect()
            ->route('opportunities.manage')
            ->with('status', 'Opportunity updated.');
    }

    public function destroy(Opportunity $opportunity): RedirectResponse
    {
        $this->ensureOwnership($opportunity);
        $opportunity->delete();

        return redirect()
            ->route('opportunities.manage')
            ->with('status', 'Opportunity removed.');
    }

    private function validatedData(Request $request, ?Opportunity $opportunity = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:255'],
            'opportunity_type' => ['required', 'string', Rule::in(self::TYPES)],
            'mode' => ['required', 'string', Rule::in(self::MODES)],
            'sdg_focus' => ['nullable', 'string', 'max:255'],
            'location_country' => ['nullable', 'string', 'max:255'],
            'location_city' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'deadline' => ['nullable', 'date'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'string', Rule::in(self::STATUSES)],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            'opportunity_type.in' => 'Choose a supported opportunity type.',
            'mode.in' => 'Mode must be onsite, remote, or hybrid.',
        ]);
    }

    private function ensureOrganization(): void
    {
        $user = Auth::user();

        if (! $user || ! $user->isOrganization()) {
            abort(403, 'Only organization accounts can manage opportunities.');
        }
    }

    private function ensureOwnership(Opportunity $opportunity): void
    {
        $this->ensureOrganization();

        if ($opportunity->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to modify this opportunity.');
        }
    }
}