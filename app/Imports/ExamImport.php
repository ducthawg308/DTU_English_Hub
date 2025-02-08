<?php

namespace App\Imports;

use App\Models\ExamQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamImport implements ToModel, WithHeadingRow
{
    protected $exam_id;

    public function __construct($exam_id){
        $this->exam_id = $exam_id;
    }

    public function model(array $row){
        return new ExamQuestion([
            'exam_id' => $this->exam_id,
            'question' => $row['question'] ?? null,
            'option_a' => $row['option_a'] ?? null,
            'option_b' => $row['option_b'] ?? null,
            'option_c' => $row['option_c'] ?? null,
            'option_d' => $row['option_d'] ?? null,
            'correct_answer' => $row['correct_answer'] ?? null,
        ]);
    }
}
