<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    // 1. LOGIKA MELAMAR (JOIN TIM)
    public function store(Request $request, Recruitment $recruitment)
    {
        $request->validate(['message' => 'required|string|max:500']);

        if (Carbon::now()->startOfDay()->gt(Carbon::parse($recruitment->deadline)->startOfDay())) {
            return back()->with('error', 'Maaf, pendaftaran sudah ditutup (melewati deadline).');
        }

        $exists = Application::where('recruitment_id', $recruitment->id)
                    ->where('user_id', Auth::id())->exists();
        
        if($exists) {
            return back()->with('error', 'Anda sudah melamar ke tim ini sebelumnya.');
        }

        Application::create([
            'recruitment_id' => $recruitment->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending',
            'is_pinned' => false
        ]);

        return back()->with('success', 'Permintaan bergabung berhasil dikirim! Tunggu konfirmasi ketua tim.');
    }

    // 2. HALAMAN "KELOLA TIM SAYA" (LEADER VIEW)
    public function index()
    {
        $myRecruitments = Recruitment::with(['applications.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('my-teams', compact('myRecruitments'));
    }

    // 3. HALAMAN "RIWAYAT LAMARAN SAYA" (MEMBER VIEW)
    public function joined()
    {
        $joinedTeams = Application::with(['recruitment.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('joined-teams', compact('joinedTeams'));
    }

    // 4. LOGIKA TERIMA/TOLAK PELAMAR (LEADER ACTION)
    public function updateStatus(Request $request, Application $application)
    {
        if ($application->recruitment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application->update(['status' => $request->status]);

        $statusMsg = $request->status == 'accepted' ? 'diterima' : 'ditolak';
        return back()->with('success', "Pelamar berhasil $statusMsg.");
    }

    // 5. LOGIKA PIN PORTFOLIO (Member Action - Unused in Profile Controller but kept for specific route)
    public function togglePin(Application $application)
    {
        if($application->user_id !== Auth::id()) abort(403);

        if (!$application->is_pinned) {
            $count = Application::where('user_id', Auth::id())->where('is_pinned', true)->count();
            if ($count >= 3) {
                return back()->with('error', 'Maksimal hanya 3 tim yang bisa ditampilkan di profil.');
            }
        }

        $application->is_pinned = !$application->is_pinned;
        $application->save();

        return back()->with('success', "Portfolio diperbarui.");
    }
}