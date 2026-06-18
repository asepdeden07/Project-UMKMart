<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the admin profile
     */
    public function show()
    {
        $admin = auth()->user();
        return view('admin.profile.show', compact('admin'));
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $admin = auth()->user();
        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * Update the admin profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        ]);

        auth()->user()->update($validated);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil admin berhasil diperbarui');
    }
}
