<?php

namespace App\Http\Controllers;

use App\Models\UserExamSubmission;
use App\Models\ExamSection;
use App\Models\WritingPrompt;
use App\Models\SpeakingPrompt;
use App\Models\Question;
use App\Models\ReadingPassage;
use App\Models\ListeningAudio;
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

        // Calculate average score for each skill
        foreach ($scores as $skill => &$score) {
            if ($skillCounts[$skill] > 0) {
                $score = round($score / $skillCounts[$skill], 1);
            }
        }

        // Calculate overall average score
        $validScores = array_filter($scores, function ($score) {
            return $score > 0;
        });
        $avg = count($validScores) > 0 ? round(array_sum($validScores) / count($validScores), 1) : 0;

        // Determine current VSTEP level
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

        // Determine weakest skill
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
            // Threshold for low scores
            $threshold = 5.0;

            // Query submissions with low scores in the weakest skill
            $weakSubmissions = UserExamSubmission::where('user_id', $user->id)
                ->where('status', '!=', 'pending')
                ->where($weakestSkill . '_score', '>', 0)
                ->where($weakestSkill . '_score', '<', $threshold)
                ->get();

            // Fetch unique weak topics based on the weakest skill
            $uniqueTitles = []; // To track unique titles
            foreach ($weakSubmissions as $submission) {
                $sections = ExamSection::where('exam_id', $submission->exam_id)
                    ->where('skill', $weakestSkill)
                    ->get();

                foreach ($sections as $section) {
                    if ($weakestSkill === 'writing') {
                        $prompts = WritingPrompt::where('exam_section_id', $section->id)->get();
                        foreach ($prompts as $prompt) {
                            if (!in_array($prompt->title, $uniqueTitles) && $prompt->title) {
                                $weakTopics[] = $prompt->title;
                                $uniqueTitles[] = $prompt->title;
                            }
                        }
                    } elseif ($weakestSkill === 'speaking') {
                        $prompts = SpeakingPrompt::where('exam_section_id', $section->id)->get();
                        foreach ($prompts as $prompt) {
                            if (!in_array($prompt->title, $uniqueTitles) && $prompt->title) {
                                $weakTopics[] = $prompt->title;
                                $uniqueTitles[] = $prompt->title;
                            }
                        }
                    } elseif ($weakestSkill === 'listening') {
                        $audios = ListeningAudio::where('exam_section_id', $section->id)->get();
                        foreach ($audios as $audio) {
                            if (!in_array($audio->title, $uniqueTitles) && $audio->title) {
                                $weakTopics[] = $audio->title;
                                $uniqueTitles[] = $audio->title;
                            }
                        }
                    } elseif ($weakestSkill === 'reading') {
                        $passages = ReadingPassage::where('exam_section_id', $section->id)->get();
                        foreach ($passages as $passage) {
                            if (!in_array($passage->title, $uniqueTitles) && $passage->title) {
                                $weakTopics[] = $passage->title;
                                $uniqueTitles[] = $passage->title;
                            }
                        }
                    }
                }
            }

            // Limit to 5 topics
            $weakTopics = array_slice($weakTopics, 0, 5);
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