<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Notifications\WriterRequestNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function requestWriter(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        if ($user->isAdmin()) {
            return Redirect::route('profile.edit')->with('error', 'Admin tidak perlu mengajukan status penulis.');
        }

        if ($user->writer_status === 'pending') {
            return Redirect::route('profile.edit')->with('error', 'Pengajuan Anda masih menunggu persetujuan admin.');
        }

        if ($user->writer_status === 'approved') {
            return Redirect::route('profile.edit')->with('error', 'Anda sudah disetujui sebagai penulis.');
        }

        $validated = $request->validate([
            'writer_application_email' => ['required', 'email', 'max:255'],
            'writer_application_motivation' => ['required', 'string', 'min:20', 'max:2000'],
            'writer_application_experience' => ['required', 'string', 'min:10', 'max:2000'],
            'writer_application_genre' => ['required', 'string', 'max:255'],
            'writer_application_agreement' => ['accepted'],
        ]);
        unset($validated['writer_application_agreement']);

        $user->update([
            'role' => 'user',
            'writer_status' => 'pending',
            'writer_rejection_reason' => null,
            ...$validated,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new WriterRequestNotification($user));
        }

        return Redirect::route('profile.edit')->with('success', 'Pengajuan menjadi penulis berhasil dikirim. Silakan tunggu persetujuan admin.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
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
