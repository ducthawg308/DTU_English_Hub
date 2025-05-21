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
        // Logic remains the same as provided
        $writingSubmissions = UserExamSubmission::join('user_written_responses', 'user_exam_submissions.id', '=', 'user_written_responses.submission_id')
            ->join('users', 'user_exam_submissions.user_id', '=', 'users.id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->where('user_exam_submissions.status', '=', 'pending')
            ->select(
                'user_exam_submissions.id as submission_id',
                'user_exam_submissions.user_id',
                'user_exam_submissions.exam_id',
                'user_exam_submissions.submitted_at',
                'user_exam_submissions.writing_score',
                'user_written_responses.id as writing_response_id',
                'user_written_responses.teacher_score as writing_teacher_score',
                'users.name as student_name',
                'exams.title as exam_title'
            )
            ->get()
            ->toArray();

        $speakingSubmissions = UserExamSubmission::join('user_speaking_responses', 'user_exam_submissions.id', '=', 'user_speaking_responses.submission_id')
            ->join('users', 'user_exam_submissions.user_id', '=', 'users.id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->where('user_exam_submissions.status', '=', 'pending')
            ->select(
                'user_exam_submissions.id as submission_id',
                'user_exam_submissions.user_id',
                'user_exam_submissions.exam_id',
                'user_exam_submissions.submitted_at',
                'user_exam_submissions.speaking_score',
                'user_speaking_responses.id as speaking_response_id',
                'user_speaking_responses.teacher_score as speaking_teacher_score',
                'users.name as student_name',
                'exams.title as exam_title'
            )
            ->get()
            ->toArray();

        $students = [];
        
        foreach ($writingSubmissions as $submission) {
            $userId = $submission['user_id'];
            if (!isset($students[$userId])) {
                $students[$userId] = [
                    'user_id' => $userId,
                    'student_name' => $submission['student_name'],
                    'exam_title' => $submission['exam_title'],
                    'submitted_at' => $submission['submitted_at'],
                    'writing_status' => isset($submission['writing_teacher_score']) ? 'graded' : 'pending',
                    'writing_score' => $submission['writing_score'],
                    'speaking_status' => 'none',
                    'speaking_score' => 0
                ];
            }
        }
        
        foreach ($speakingSubmissions as $submission) {
            $userId = $submission['user_id'];
            if (!isset($students[$userId])) {
                $students[$userId] = [
                    'user_id' => $userId,
                    'student_name' => $submission['student_name'],
                    'exam_title' => $submission['exam_title'],
                    'submitted_at' => $submission['submitted_at'],
                    'writing_status' => 'none',
                    'writing_score' => 0,
                    'speaking_status' => isset($submission['speaking_teacher_score']) ? 'graded' : 'pending',
                    'speaking_score' => $submission['speaking_score']
                ];
            } else {
                $students[$userId]['speaking_status'] = isset($submission['speaking_teacher_score']) ? 'graded' : 'pending';
                $students[$userId]['speaking_score'] = $submission['speaking_score'];
            }
        }
        
        $studentSubmissions = array_values($students);
        
        return view('teacher.index', compact('studentSubmissions'));
    }
    
    public function gradeCombined($userId) {
        $studentInfo = User::join('user_exam_submissions', 'users.id', '=', 'user_exam_submissions.user_id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->where('users.id', '=', $userId)
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
        
        // Fetch all writing submissions
        $writingSubmissions = UserWrittenResponse::join('writing_prompts', 'user_written_responses.writing_prompt_id', '=', 'writing_prompts.id')
            ->join('user_exam_submissions', 'user_written_responses.submission_id', '=', 'user_exam_submissions.id')
            ->where('user_exam_submissions.user_id', '=', $userId)
            ->where('user_exam_submissions.status', '=', 'pending')
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
        
        // Fetch all speaking submissions
        $speakingSubmissions = UserSpeakingResponse::join('speaking_prompts', 'user_speaking_responses.speaking_prompt_id', '=', 'speaking_prompts.id')
            ->join('user_exam_submissions', 'user_speaking_responses.submission_id', '=', 'user_exam_submissions.id')
            ->where('user_exam_submissions.user_id', '=', $userId)
            ->where('user_exam_submissions.status', '=', 'pending')
            ->select(
                'user_speaking_responses.id as response_id',
                'user_speaking_responses.audio_url',
                'user_speaking_responses.ai_score',
                'user_speaking_responses.ai_feedback',
                'user_speaking_responses.teacher_score',
                'user_speaking_responses.teacher_feedback',
                'speaking_prompts.prompt_text as speaking_prompt'
            )
            ->get();
            
        return view('teacher.grade', compact('studentInfo', 'writingSubmissions', 'speakingSubmissions'));
    }
    
    public function submitCombinedGrade(Request $request, $userId) {
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
        
        // Update writing scores and feedback
        if ($request->filled('writing_response_ids') && $request->filled('writing_teacher_scores')) {
            foreach ($validated['writing_response_ids'] as $index => $responseId) {
                $writtenResponse = UserWrittenResponse::findOrFail($responseId);
                $writtenResponse->teacher_score = $validated['writing_teacher_scores'][$index] ?? null;
                $writtenResponse->teacher_feedback = $validated['writing_teacher_feedbacks'][$index] ?? null;
                $writtenResponse->save();
            }
            
            // Calculate writing score using the formula: (Bài viết 1 + (Bài viết 2 * 2)) / 3
            $writingScores = array_intersect_key($validated['writing_teacher_scores'], array_flip($validated['writing_response_ids']));
            $writingScore = 0;
            if (count($writingScores) >= 2) {
                $writingScore = ($writingScores[array_key_first($writingScores)] + ($writingScores[array_key_last($writingScores)] * 2)) / 3;
            } elseif (count($writingScores) == 1) {
                $writingScore = $writingScores[array_key_first($writingScores)];
            }
            $examSubmission = UserExamSubmission::where('user_id', $userId)->where('status', 'pending')->firstOrFail();
            $examSubmission->writing_score = $writingScore;
            $examSubmission->save();
        }
        
        // Update speaking scores and feedback
        if ($request->filled('speaking_response_ids') && $request->filled('speaking_teacher_scores')) {
            foreach ($validated['speaking_response_ids'] as $index => $responseId) {
                $speakingResponse = UserSpeakingResponse::findOrFail($responseId);
                $speakingResponse->teacher_score = $validated['speaking_teacher_scores'][$index] ?? null;
                $speakingResponse->teacher_feedback = $validated['speaking_teacher_feedbacks'][$index] ?? null;
                $speakingResponse->save();
            }
            
            // Calculate average speaking score (optional, can be adjusted)
            $speakingScores = array_intersect_key($validated['speaking_teacher_scores'], array_flip($validated['speaking_response_ids']));
            if (!empty($speakingScores)) {
                $speakingScore = array_sum($speakingScores) / count($speakingScores);
                $examSubmission->speaking_score = $speakingScore;
                $examSubmission->save();
            }
        }
        
        // Calculate total score and update status
        $examSubmission = UserExamSubmission::where('user_id', $userId)->where('status', 'pending')->firstOrFail();
        $totalScore = 0;
        $sectionsGraded = 0;
        
        if ($examSubmission->listening_score > 0) {
            $totalScore += $examSubmission->listening_score;
            $sectionsGraded++;
        }
        if ($examSubmission->reading_score > 0) {
            $totalScore += $examSubmission->reading_score;
            $sectionsGraded++;
        }
        if ($examSubmission->writing_score > 0) {
            $totalScore += $examSubmission->writing_score;
            $sectionsGraded++;
        }
        if ($examSubmission->speaking_score > 0) {
            $totalScore += $examSubmission->speaking_score;
            $sectionsGraded++;
        }
        
        $examSubmission->total_score = $totalScore;
        $examSubmission->status = 'graded';
        $examSubmission->save();
        
        return redirect()->route('teacher.combined')->with('status', 'Chấm điểm thành công!');
    }
}