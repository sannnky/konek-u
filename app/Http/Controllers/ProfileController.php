<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Application;
use App\Models\Recruitment; // Import Recruitment
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Tampilkan Profil Publik dengan Portfolio Gabungan
    public function show(User $user): View
    {
        // 1. Ambil Project buatan user yang di-pin (Sebagai Leader)
        $pinnedOwned = $user->recruitments()
                        ->where('is_pinned', true)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'title' => $item->title,
                                'category' => $item->category,
                                'status' => $item->status,
                                'role' => 'Leader',
                                'link' => route('recruitments.show', $item->id)
                            ];
                        });

        // 2. Ambil Project yang diikuti user yang di-pin (Sebagai Member)
        $pinnedJoined = $user->applications()
                        ->where('is_pinned', true)
                        ->with('recruitment')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'title' => $item->recruitment->title,
                                'category' => $item->recruitment->category,
                                'status' => $item->recruitment->status,
                                'role' => 'Member',
                                'link' => route('recruitments.show', $item->recruitment->id)
                            ];
                        });

        // 3. Gabungkan keduanya
        $portfolio = $pinnedOwned->merge($pinnedJoined);

        return view('profile.show', [
            'user' => $user,
            'portfolio' => $portfolio
        ]);
    }

    public function edit(Request $request): View
    {
        $user = $request->user();

        // Ambil list project buatan sendiri
        $ownedTeams = Recruitment::where('user_id', $user->id)->latest()->get();

        // Ambil list project yang diikuti
        $joinedTeams = Application::with('recruitment')
                        ->where('user_id', $user->id)
                        ->where('status', 'accepted')
                        ->latest()
                        ->get();

        return view('profile.edit', [
            'user' => $user,
            'ownedTeams' => $ownedTeams,
            'joinedTeams' => $joinedTeams,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());
        $user->bio = $request->bio;
        $user->skills = $request->skills;
        $user->major = $request->major;
        
        // Upload Avatar
        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'image|max:2048']);
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // --- UPDATE PORTFOLIO ---
        // 1. Reset semua pin user ini jadi false dulu
        Recruitment::where('user_id', $user->id)->update(['is_pinned' => false]);
        Application::where('user_id', $user->id)->update(['is_pinned' => false]);

        // 2. Simpan pilihan baru
        if ($request->has('portfolio')) {
            // Ambil maksimal 3 input pertama
            $selected = array_slice($request->portfolio, 0, 3);

            foreach ($selected as $item) {
                // Format value dari form: "type_id" (contoh: "rec_1" atau "app_5")
                [$type, $id] = explode('_', $item);

                if ($type == 'rec') {
                    // Update Recruitment (Leader)
                    Recruitment::where('id', $id)->where('user_id', $user->id)->update(['is_pinned' => true]);
                } elseif ($type == 'app') {
                    // Update Application (Member)
                    Application::where('id', $id)->where('user_id', $user->id)->update(['is_pinned' => true]);
                }
            }
        }

        if ($user->isDirty('email')) $user->email_verified_at = null;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', ['password' => ['required', 'current_password']]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}