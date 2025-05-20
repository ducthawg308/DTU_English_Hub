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

        $submissions = UserExamSubmission::where('user_id', $user->id)
            ->where('status', '!=', 'pending')
            ->get();

        $scores = [
            'listening' => 0,
            'reading' => 0,
            'writing' => 0,
            'speaking' => 0,
        ];

        $skillCounts = [
            'listening' => 0,
            'reading' => 0,
            'writing' => 0,
            'speaking' => 0,
        ];

        foreach ($submissions as $submission) {
            if ($submission->listening_score > 0) {
                $scores['listening'] += $submission->listening_score;
                $skillCounts['listening']++;
            }
            if ($submission->reading_score > 0) {
                $scores['reading'] += $submission->reading_score;
                $skillCounts['reading']++;
            }
            if ($submission->writing_score > 0) {
                $scores['writing'] += $submission->writing_score;
                $skillCounts['writing']++;
            }
            if ($submission->speaking_score > 0) {
                $scores['speaking'] += $submission->speaking_score;
                $skillCounts['speaking']++;
            }
        }

        // Tính điểm trung bình cho từng kỹ năng
        foreach ($scores as $skill => &$score) {
            if ($skillCounts[$skill] > 0) {
                $score = round($score / $skillCounts[$skill], 1); // Làm tròn 1 chữ số thập phân
            }
        }

        // Tính điểm trung bình tổng của các kỹ năng
        $validScores = array_filter($scores, function ($score) {
            return $score > 0;
        });
        $avg = count($validScores) > 0 ? round(array_sum($validScores) / count($validScores), 1) : 0;

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
            ->take(5)
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