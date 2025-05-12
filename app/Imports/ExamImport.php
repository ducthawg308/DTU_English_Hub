<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExamImport implements WithMultipleSheets
{
    protected $exam_id;

    public function __construct($exam_id)
    {
        $this->exam_id = $exam_id;
    }

    public function sheets(): array
    {
        return [
            'Listening' => new ListeningSheetImport($this->exam_id),
            'Reading' => new ReadingSheetImport($this->exam_id),
            'Writing' => new WritingSheetImport($this->exam_id),
            'Speaking' => new SpeakingSheetImport($this->exam_id),
        ];
    }
}