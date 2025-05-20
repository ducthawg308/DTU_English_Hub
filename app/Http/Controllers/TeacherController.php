<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExamSubmission;
use App\Models\UserWrittenResponse;
use App\Models\Exam;
use App\Models\WritingPrompt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    public function show(){
        return view('teacher.index');
    }

    public function showWriting(){
        // Get all writing submissions that need teacher grading
        $pendingSubmissions = UserExamSubmission::join('user_written_responses', 'user_exam_submissions.id', '=', 'user_written_responses.submission_id')
            ->join('users', 'user_exam_submissions.user_id', '=', 'users.id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->join('writing_prompts', 'user_written_responses.writing_prompt_id', '=', 'writing_prompts.id')
            ->where('user_exam_submissions.status', '=', 'pending')
            ->select(
                'user_exam_submissions.id as submission_id',
                'user_exam_submissions.user_id',
                'user_exam_submissions.exam_id',
                'user_exam_submissions.submitted_at',
                'user_exam_submissions.writing_score',
                'user_written_responses.id as response_id',
                'user_written_responses.writing_prompt_id',
                'user_written_responses.response_text',
                'user_written_responses.ai_score',
                'user_written_responses.ai_feedback',
                'users.name as student_name',
                'exams.title as exam_title',
                'writing_prompts.prompt_text as writing_prompt'
            )
            ->orderBy('user_exam_submissions.submitted_at', 'desc')
            ->get();

        return view('teacher.writing.index', compact('pendingSubmissions'));
    }

    public function gradeWriting($id) {
        // Get the specific writing submission to grade
        $submission = UserWrittenResponse::join('user_exam_submissions', 'user_written_responses.submission_id', '=', 'user_exam_submissions.id')
            ->join('users', 'user_exam_submissions.user_id', '=', 'users.id')
            ->join('exams', 'user_exam_submissions.exam_id', '=', 'exams.id')
            ->join('writing_prompts', 'user_written_responses.writing_prompt_id', '=', 'writing_prompts.id')
            ->where('user_written_responses.id', $id)
            ->select(
                'user_exam_submissions.id as submission_id',
                'user_exam_submissions.user_id',
                'user_exam_submissions.exam_id',
                'user_written_responses.id as response_id',
                'user_written_responses.response_text',
                'user_written_responses.ai_score',
                'user_written_responses.ai_feedback',
                'users.name as student_name',
                'exams.title as exam_title',
                'writing_prompts.prompt_text as writing_prompt'
            )
            ->first();

        return view('teacher.writing.grade', compact('submission'));
    }

    public function submitGrade(Request $request, $id) {
        // Validate the teacher's grading
        $validated = $request->validate([
            'teacher_score' => 'required|numeric|min:0|max:9',
            'teacher_feedback' => 'required|string',
        ]);

        // Find the written response
        $writtenResponse = UserWrittenResponse::findOrFail($id);
        
        // Update the written response with teacher's grade
        $writtenResponse->teacher_score = $validated['teacher_score'];
        $writtenResponse->teacher_feedback = $validated['teacher_feedback'];
        $writtenResponse->save();

        // Update the overall exam submission
        $examSubmission = UserExamSubmission::findOrFail($writtenResponse->submission_id);
        
        // Update writing score with teacher's score
        $examSubmission->writing_score = $validated['teacher_score'];
        
        // Log before check
        Log::info('Checking scores for submission #' . $examSubmission->id, [
            'listening_score' => $examSubmission->listening_score,
            'reading_score' => $examSubmission->reading_score,
            'writing_score' => $examSubmission->writing_score,
            'speaking_score' => $examSubmission->speaking_score
        ]);
        
        // Calculate total score regardless of other sections
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
        
        // Update total score
        $examSubmission->total_score = $totalScore;
        
        // Always change status to 'graded' after teacher has graded the writing section
        $examSubmission->status = 'graded';
        
        // Debug info
        Log::info('Updating submission status', [
            'submission_id' => $examSubmission->id,
            'total_score' => $totalScore,
            'sections_graded' => $sectionsGraded,
            'new_status' => $examSubmission->status
        ]);
        
        // Save changes
        $examSubmission->save();
        
        // Verify that changes were saved
        $updatedSubmission = UserExamSubmission::find($examSubmission->id);
        Log::info('Submission after update', [
            'status' => $updatedSubmission->status,
            'total_score' => $updatedSubmission->total_score
        ]);

        return redirect()->route('teacher.writing')->with('status', 'Bài viết đã được chấm điểm thành công!');
    }

    public function showSpeaking(){
        return view('teacher.speaking.index');
    }
}