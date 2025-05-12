<?php

namespace App\Http\Controllers;

use App\Imports\ExamImport;
use App\Models\Exam;
use App\Models\Level;
use App\Models\TypeTopic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminExamController extends Controller
{
    public function list() {
        $exams = Exam::all();
        return view('admin.exam.list', compact('exams'));
    }

    public function add() {
        $levels = TypeTopic::all();
        return view('admin.exam.add', compact('levels'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'desc' => 'nullable|string',
            'level' => 'required|in:A1,A2,B1,B2,C1,C2',
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Tạo bài thi
        $exam = Exam::create([
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
            'level' => $request->input('level'),
        ]);

        try {
            Excel::import(new ExamImport($exam->id), $request->file('file'));
        } catch (\Exception $e) {
            $exam->delete();
            return back()->withErrors(['file' => 'Lỗi khi import file: ' . $e->getMessage()]);
        }

        return redirect('admin/exam/list')->with('status', 'Thêm bài thi thành công!');
    }

    public function delete($id) {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return redirect('admin/exam/list')->with('status', 'Xóa bài thi thành công!');
    }
}
