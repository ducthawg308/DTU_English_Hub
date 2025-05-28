<?php

namespace App\Imports;

use App\Models\ExamSection;
use App\Models\WritingPrompt;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WritingSheetImport implements ToCollection, WithHeadingRow
{
    protected $exam_id;

    public function __construct($exam_id)
    {
        $this->exam_id = $exam_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $section = ExamSection::firstOrCreate([
                'exam_id' => $this->exam_id,
                'skill' => 'writing',
                'instruction' => $row['part'] ?? '1'
            ]);

            WritingPrompt::firstOrCreate([
                'exam_section_id' => $section->id,
                'title' => $row['title'],
                'prompt_text' => $row['prompt_text']
            ]);
        }
    }
}