<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    // URL: GET /profile    
    public function edit(Request $request): View
    {
        $user = $request->user();

        $view = $user->role === 'staff' ? 'staff.profil' : 'customer.profil';

        return view(view()->exists($view) ? $view : 'profile.edit', compact('user'));
    }

    // Simpan nama, email, dan telepon
    // URL: PATCH /profile  (field: name, email, phone)
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Hapus akun (hanya customer)
    // URL: DELETE /profile  (field: password)
    public function destroy(Request $request): RedirectResponse
    {
        // Akun staff dibuat lewat seeder, jadi tidak boleh dihapus sendiri
        if ($request->user()->role === 'staff') {
            return Redirect::route('profile.edit')
                ->with('error', 'Akun staff tidak bisa dihapus sendiri.');
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
