<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExamSubmission;
use App\Models\UserWrittenResponse;
use App\Models\Exam;
use App\Models\WritingPrompt;
use App\Models\User;
use App\Models\UserSpeakingResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    // Existing methods remain unchanged...

    public function showCombined() {
        // Lấy tất cả bài kiểm tra có trạng thái pending
        $submissions = UserExamSubmission::join('users', 'user_exam_submissions.user_id', '=', 'users.id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->where('user_exam_submissions.status', '=', 'pending')
            ->select(
                'user_exam_submissions.id as submission_id',
                'user_exam_submissions.user_id',
                'user_exam_submissions.exam_id',
                'user_exam_submissions.submitted_at',
                'user_exam_submissions.writing_score',
                'user_exam_submissions.speaking_score',
                'users.name as student_name',
                'exams.title as exam_title'
            )
            ->get()
            ->toArray();

        // Tạo danh sách bài nộp với thông tin writing và speaking
        $studentSubmissions = [];
        foreach ($submissions as $submission) {
            $writingResponses = UserWrittenResponse::where('submission_id', $submission['submission_id'])
                ->select('id as writing_response_id', 'teacher_score as writing_teacher_score')
                ->get()
                ->toArray();

            $speakingResponses = UserSpeakingResponse::where('submission_id', $submission['submission_id'])
                ->select('id as speaking_response_id', 'teacher_score as speaking_teacher_score')
                ->get()
                ->toArray();

            $studentSubmissions[] = [
                'submission_id' => $submission['submission_id'],
                'user_id' => $submission['user_id'],
                'student_name' => $submission['student_name'],
                'exam_title' => $submission['exam_title'],
                'submitted_at' => $submission['submitted_at'],
                'writing_status' => !empty($writingResponses) ? ($writingResponses[0]['writing_teacher_score'] !== null ? 'graded' : 'pending') : 'none',
                'writing_score' => $submission['writing_score'] ?? 0,
                'speaking_status' => !empty($speakingResponses) ? ($speakingResponses[0]['speaking_teacher_score'] !== null ? 'graded' : 'pending') : 'none',
                'speaking_score' => $submission['speaking_score'] ?? 0,
            ];
        }

        return view('teacher.index', compact('studentSubmissions'));
    }
    
    public function gradeCombined($userId, $submissionId) {
        $studentInfo = User::join('user_exam_submissions', 'users.id', '=', 'user_exam_submissions.user_id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->where('users.id', '=', $userId)
            ->where('user_exam_submissions.id', '=', $submissionId)
            ->where('user_exam_submissions.status', '=', 'pending')
            ->select(
                'users.id as user_id',
                'users.name as student_name',
                'exams.title as exam_title',
                'user_exam_submissions.id as submission_id'
            )
            ->first();
            
        if (!$studentInfo) {
            return redirect()->route('teacher.combined')->with('error', 'Không tìm thấy thông tin học viên hoặc bài thi.');
        }
        
        // Fetch all writing submissions for the specific submission_id
        $writingSubmissions = UserWrittenResponse::join('writing_prompts', 'user_written_responses.writing_prompt_id', '=', 'writing_prompts.id')
            ->where('user_written_responses.submission_id', '=', $submissionId)
            ->select(
                'user_written_responses.id as response_id',
                'user_written_responses.response_text',
                'user_written_responses.ai_score',
                'user_written_responses.ai_feedback',
                'user_written_responses.teacher_score',
                'user_written_responses.teacher_feedback',
                'writing_prompts.prompt_text as writing_prompt'
            )
            ->get();
        
        // Fetch all speaking submissions for the specific submission_id
        $speakingSubmissions = UserSpeakingResponse::join('speaking_prompts', 'user_speaking_responses.speaking_prompt_id', '=', 'speaking_prompts.id')
            ->where('user_speaking_responses.submission_id', '=', $submissionId)
            ->select(
                'user_speaking_responses.id as response_id',
                'user_speaking_responses.audio_url',
                // 'user_speaking_responses.ai_score',
                // 'user_speaking_responses.ai_feedback',
                'user_speaking_responses.teacher_score',
                'user_speaking_responses.teacher_feedback',
                'speaking_prompts.prompt_text as speaking_prompt'
            )
            ->get();
            
        return view('teacher.grade', compact('studentInfo', 'writingSubmissions', 'speakingSubmissions'));
    }
    
    public function submitCombinedGrade(Request $request, $userId, $submissionId)
    {
        Log::info('submitCombinedGrade called with userId: ' . $userId . ', submissionId: ' . $submissionId);
        Log::info('Request data: ', $request->all());

        $validated = $request->validate([
            'writing_response_ids' => 'nullable|array',
            'writing_response_ids.*' => 'exists:user_written_responses,id',
            'writing_teacher_scores' => 'nullable|array',
            'writing_teacher_scores.*' => 'numeric|min:0|max:9',
            'writing_teacher_feedbacks' => 'nullable|array',
            'speaking_response_ids' => 'nullable|array',
            'speaking_response_ids.*' => 'exists:user_speaking_responses,id',
            'speaking_teacher_scores' => 'nullable|array',
            'speaking_teacher_scores.*' => 'numeric|min:0|max:9',
            'speaking_teacher_feedbacks' => 'nullable|array',
        ]);

        Log::info('Validated data: ', $validated);

        // Fetch the exam submission once to avoid repeated queries
        $examSubmission = UserExamSubmission::where('id', $submissionId)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->firstOrFail();

        // Update writing scores and feedback
        $writingScore = 0;
        if ($request->filled('writing_response_ids') && $request->filled('writing_teacher_scores')) {
            Log::info('Processing writing responses. Count: ' . count($validated['writing_response_ids']));
            foreach ($validated['writing_response_ids'] as $index => $responseId) {
                Log::info("Processing writing response_id: $responseId, index: $index");
                $writtenResponse = UserWrittenResponse::findOrFail($responseId);
                $writtenResponse->teacher_score = $validated['writing_teacher_scores'][$index] ?? null;
                $writtenResponse->teacher_feedback = $validated['writing_teacher_feedbacks'][$index] ?? null;
                Log::info("Updating response $responseId with score: " . ($validated['writing_teacher_scores'][$index] ?? 'null') . ", feedback: " . ($validated['writing_teacher_feedbacks'][$index] ?? 'null'));
                $writtenResponse->save();
                Log::info("Save result for response $responseId: " . ($writtenResponse->wasChanged() ? 'Success' : 'No change'));
            }
            
            // Calculate writing score: (Bài 1 + (Bài 2 * 2)) / 3
            $writingScores = array_filter($validated['writing_teacher_scores'], function($score) {
                return is_numeric($score) && $score >= 0 && $score <= 9;
            });
            Log::info('Writing scores for calculation: ', $writingScores);
            
            if (count($writingScores) >= 2) {
                $firstScore = (float) array_shift($writingScores);
                $secondScore = (float) array_shift($writingScores);
                $writingScore = ($firstScore + ($secondScore * 2)) / 3;
            } elseif (count($writingScores) == 1) {
                $writingScore = (float) reset($writingScores);
            }
            
            $examSubmission->writing_score = round($writingScore, 1);
            Log::info("Calculated writing_score: {$examSubmission->writing_score}");
            $examSubmission->save();
        }
        
        // Update speaking scores and feedback
        $speakingScore = 0;
        if ($request->filled('speaking_response_ids') && $request->filled('speaking_teacher_scores')) {
            Log::info('Processing speaking responses. Count: ' . count($validated['speaking_response_ids']));
            foreach ($validated['speaking_response_ids'] as $index => $responseId) {
                Log::info("Processing speaking response_id: $responseId, index: $index");
                $speakingResponse = UserSpeakingResponse::findOrFail($responseId);
                $speakingResponse->teacher_score = $validated['speaking_teacher_scores'][$index] ?? null;
                $speakingResponse->teacher_feedback = $validated['speaking_teacher_feedbacks'][$index] ?? null;
                Log::info("Updating response $responseId with score: " . ($validated['speaking_teacher_scores'][$index] ?? 'null') . ", feedback: " . ($validated['speaking_teacher_feedbacks'][$index] ?? 'null'));
                $speakingResponse->save();
                Log::info("Save result for response $responseId: " . ($speakingResponse->wasChanged() ? 'Success' : 'No change'));
            }
            
            // Calculate speaking score: (Bài 1 + Bài 2 + Bài 3) / 3
            $speakingScores = array_filter($validated['speaking_teacher_scores'], function($score) {
                return is_numeric($score) && $score >= 0 && $score <= 9;
            });
            Log::info('Speaking scores for calculation: ', $speakingScores);
            
            if (!empty($speakingScores)) {
                $speakingScore = array_sum($speakingScores) / count($speakingScores);
                $examSubmission->speaking_score = round($speakingScore, 1);
                Log::info("Calculated speaking_score: {$examSubmission->speaking_score}");
                $examSubmission->save();
            }
        }
        
        // Calculate total score: listening_score + reading_score + writing_score + speaking_score
        $totalScore = 0;
        
        $listeningScore = $examSubmission->listening_score ?? 0;
        $readingScore = $examSubmission->reading_score ?? 0;
        $writingScore = $examSubmission->writing_score ?? 0;
        $speakingScore = $examSubmission->speaking_score ?? 0;
        
        if ($listeningScore > 0) {
            $totalScore += $listeningScore;
        }
        if ($readingScore > 0) {
            $totalScore += $readingScore;
        }
        if ($writingScore > 0) {
            $totalScore += $writingScore;
        }
        if ($speakingScore > 0) {
            $totalScore += $speakingScore;
        }
        
        $examSubmission->total_score = round($totalScore, 1);
        $examSubmission->status = 'graded';
        Log::info("Calculated total_score: {$examSubmission->total_score}");
        $examSubmission->save();
        Log::info("Final exam submission updated: ", $examSubmission->toArray());
        
        return redirect()->route('teacher.combined')->with('status', 'Chấm điểm thành công!');
    }
}