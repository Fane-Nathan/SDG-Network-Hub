<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $recentOpportunities = collect();
        $recentApplications = collect();
        $metrics = [];

        if ($user->isOrganization()) {
            $recentOpportunities = $user->opportunities()
                ->withCount('applications')
                ->latest()
                ->take(5)
                ->get();

            $metrics = [
                'total_opportunities' => $user->opportunities()->count(),
                'total_applications' => $user->opportunities()->withCount('applications')->get()->sum('applications_count'),
                'open_opportunities' => $user->opportunities()->where('status', 'open')->count(),
            ];
        } else {
            $recentApplications = $user->applications()
                ->with('opportunity.owner')
                ->latest()
                ->take(5)
                ->get();

            $metrics = [
                'submitted_applications' => $user->applications()->count(),
                'open_opportunities' => Opportunity::published()->count(),
            ];
        }

        return view('dashboard', [
            'user' => $user,
            'recentOpportunities' => $recentOpportunities,
            'recentApplications' => $recentApplications,
            'metrics' => $metrics,
        ]);
    }
}