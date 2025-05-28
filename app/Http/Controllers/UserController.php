<?php

namespace App\Http\Controllers;

use App\Models\UserExamSubmission;
use App\Models\ExamSection;
use App\Models\WritingPrompt;
use App\Models\SpeakingPrompt;
use App\Models\Question;
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

        // Xác định kỹ năng yếu nhất
        $weakestSkill = null;
        $weakTopics = [];

        $filteredScores = array_filter($scores, function ($score) {
            return $score > 0;
        });
        if (!empty($filteredScores)) {
            $minScore = min($filteredScores);
            $weakestSkill = array_search($minScore, $scores);
        }

        if ($weakestSkill) {
            // Ngưỡng điểm thấp (dưới 5.0 cho kỹ năng yếu nhất)
            $threshold = 5.0;

            // Truy vấn các bài thi có điểm thấp trong kỹ năng yếu nhất
            $weakSubmissions = UserExamSubmission::where('user_id', $user->id)
                ->where('status', '!=', 'pending')
                ->where($weakestSkill . '_score', '>', 0)
                ->where($weakestSkill . '_score', '<', $threshold)
                ->get();

            // Lấy danh sách chủ đề từ các bài thi yếu
            foreach ($weakSubmissions as $submission) {
                $sections = ExamSection::where('exam_id', $submission->exam_id)
                    ->where('skill', $weakestSkill)
                    ->get();

                foreach ($sections as $section) {
                    if ($weakestSkill === 'writing') {
                        $prompts = WritingPrompt::where('exam_section_id', $section->id)->get();
                        foreach ($prompts as $prompt) {
                            $weakTopics[] = [
                                'title' => $prompt->title,
                                'topic' => $prompt->topic ?? 'Chưa xác định',
                                'score' => $submission->writing_score,
                            ];
                        }
                    } elseif ($weakestSkill === 'speaking') {
                        $prompts = SpeakingPrompt::where('exam_section_id', $section->id)->get();
                        foreach ($prompts as $prompt) {
                            $weakTopics[] = [
                                'title' => $prompt->title,
                                'topic' => $prompt->topic ?? 'Chưa xác định',
                                'score' => $submission->speaking_score,
                            ];
                        }
                    } elseif (in_array($weakestSkill, ['listening', 'reading'])) {
                        $questions = Question::where('exam_section_id', $section->id)->get();
                        foreach ($questions as $question) {
                            $weakTopics[] = [
                                'title' => $question->question_text,
                                'topic' => $question->question_text ?? 'Chưa xác định', // Giả định topic từ question_text
                                'score' => $submission->{$weakestSkill . '_score'},
                            ];
                        }
                    }
                }
            }

            // Loại bỏ trùng lặp và giới hạn số lượng chủ đề
            $weakTopics = collect($weakTopics)->unique('title')->take(5)->toArray();
        }

        return view('account.result', compact('user', 'scores', 'history', 'currentLevel', 'weakestSkill', 'weakTopics'));
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