<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecruitmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Recruitment::with('user')->whereIn('status', ['open', 'ongoing']);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $recruitments = $query->latest()->get();
        return view('dashboard', compact('recruitments'));
    }

    public function create()
    {
        return view('recruitments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
        ]);

        Recruitment::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'location' => $request->location ?? 'Unsika',
            'deadline' => $request->deadline,
            'status' => 'open'
        ]);

        return redirect()->route('dashboard')->with('success', 'Rekrutmen berhasil dibuat!');
    }

    public function show(Recruitment $recruitment)
    {
        $isLeader = $recruitment->user_id === Auth::id();
        
        $isMember = $recruitment->applications()
                        ->where('user_id', Auth::id())
                        ->where('status', 'accepted')
                        ->exists();
        
        $hasApplied = $recruitment->applications()
                        ->where('user_id', Auth::id())
                        ->exists();

        $chats = [];
        if($isLeader || $isMember) {
            $chats = $recruitment->messages()->with('user')->oldest()->get();
        }

        return view('recruitments.show', compact('recruitment', 'hasApplied', 'isLeader', 'isMember', 'chats'));
    }

    public function updateStatus(Request $request, Recruitment $recruitment)
    {
        if ($recruitment->user_id !== Auth::id()) abort(403);
        
        $recruitment->update(['status' => $request->status]);
        return back()->with('success', 'Status proyek diperbarui.');
    }

    public function uploadFile(Request $request, Recruitment $recruitment)
    {
        if ($recruitment->user_id !== Auth::id()) abort(403);

        $request->validate([
            'proposal_file' => 'required|mimes:pdf|max:5048',
        ]);

        if ($recruitment->proposal_file) {
            Storage::disk('public')->delete($recruitment->proposal_file);
        }

        $path = $request->file('proposal_file')->store('proposals', 'public');
        $recruitment->update(['proposal_file' => $path]);

        return back()->with('success', 'File berhasil diupload.');
    }

    public function sendMessage(Request $request, Recruitment $recruitment)
    {
        $isLeader = $recruitment->user_id === Auth::id();
        $isMember = $recruitment->applications()->where('user_id', Auth::id())->where('status', 'accepted')->exists();

        if (!$isLeader && !$isMember) abort(403);

        $request->validate(['message' => 'required']);

        Message::create([
            'recruitment_id' => $recruitment->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Pesan terkirim');
    }
}