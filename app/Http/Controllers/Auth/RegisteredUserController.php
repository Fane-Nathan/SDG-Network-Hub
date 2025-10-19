<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['organization', 'individual'])],
            'password' => ['required', 'confirmed', 'min:8'],
            'organization_name' => ['required_if:role,organization', 'nullable', 'string', 'max:255'],
            'organization_type' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'location_country' => ['nullable', 'string', 'max:255'],
            'location_city' => ['nullable', 'string', 'max:255'],
            'focus_areas' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ], [
            'organization_name.required_if' => 'Organizations must provide an organization name.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'organization_name' => $validated['organization_name'] ?? null,
            'organization_type' => $validated['organization_type'] ?? null,
            'website' => $validated['website'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
            'location_country' => $validated['location_country'] ?? null,
            'location_city' => $validated['location_city'] ?? null,
            'focus_areas' => $validated['focus_areas'] ?? null,
            'skills' => $validated['skills'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to the SDG Network Hub!');
    }
}