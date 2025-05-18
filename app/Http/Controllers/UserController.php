<?php

namespace App\Http\Controllers;

use App\Models\UserExamSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();   
        return view('account.index', compact('user'));
    }

    public function result()
    {
        $user = Auth::user();

        $latestSubmission = UserExamSubmission::where('user_id', $user->id)
            ->where('status', '!=', 'draft')
            ->orderByDesc('submitted_at')
            ->first();

        $scores = [
            'listening' => $latestSubmission->listening_score ?? 0,
            'reading' => $latestSubmission->reading_score ?? 0,
            'writing' => $latestSubmission->writing_score ?? 0,
            'speaking' => $latestSubmission->speaking_score ?? 0,
        ];

        $avg = array_sum($scores) / (count(array_filter($scores)) ?: 1);

        if ($avg >= 8.5) {
            $currentLevel = 'VSTEP Bậc 5 (C1)';
        } elseif ($avg >= 6.0) {
            $currentLevel = 'VSTEP Bậc 4 (B2)';
        } elseif ($avg >= 4.0) {
            $currentLevel = 'VSTEP Bậc 3 (B1)';
        } elseif ($avg > 0) {
            $currentLevel = 'Dưới Bậc 3';
        } else {
            $currentLevel = 'Không xét';
        }

        $history = UserExamSubmission::where('user_id', $user->id)
            ->where('status', '!=', 'draft')
            ->orderByDesc('submitted_at')
            ->take(10)
            ->get();

        return view('account.result', compact('user', 'scores', 'history', 'currentLevel'));
    }

    public function setTarget(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'target_level' => 'required|in:3,4,5',
            'target_deadline' => 'nullable|date'
        ]);

        $user->target_level = $validated['target_level'];
        $user->target_deadline = $validated['target_deadline'];
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật mục tiêu thành công!');
    }
}
