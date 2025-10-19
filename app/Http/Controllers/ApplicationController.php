<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Opportunity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if (! $user || ! $user->isIndividual()) {
            abort(403, 'Only individual accounts can view their applications.');
        }

        $applications = $user->applications()
            ->with('opportunity.owner')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('applications.index', [
            'applications' => $applications,
        ]);
    }

    public function store(Request $request, Opportunity $opportunity): RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->isIndividual()) {
            abort(403, 'Only individual accounts can apply to opportunities.');
        }

        if (! $opportunity->isOpen()) {
            return back()->withErrors(['application' => 'This opportunity is not accepting new applications.']);
        }

        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $application = Application::firstOrNew([
            'opportunity_id' => $opportunity->id,
            'user_id' => $user->id,
        ]);

        $application->message = $data['message'];
        $application->status = 'submitted';
        $application->save();

        return redirect()
            ->route('applications.mine')
            ->with('status', 'Application sent to ' . ($opportunity->owner->organization_name ?? $opportunity->owner->name) . '.');
    }
}