<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    /** GET /profil (dan /profile bawaan Breeze): halaman profil sesuai role. */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if (method_exists($user, 'outlet')) {
            $user->load('outlet');
        }

        $view = ($user->role === 'staff' && view()->exists('staff.profil')) ? 'staff.profil' : 'customer.profil';

        return view($view, ['user' => $user]);
    }

    /** PUT/PATCH /profil: simpan nama, email, telepon, dan foto profil. */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone'        => ['nullable', 'string', 'max:20'],
            'photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // maks 2 MB
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        // Diisi satu per satu (bukan mass assignment) supaya tidak bergantung pada $fillable di model User
        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Foto profil: hapus jika diminta, ganti jika ada file baru
        if ($request->boolean('remove_photo') && $user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null;
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /** DELETE /profile: hapus akun (customer saja, staff ditolak). */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role === 'staff') {
            return back()->with('error', 'Akun staff tidak bisa dihapus sendiri. Hubungi admin.');
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
