<?php

namespace App\Imports;

use App\Models\ExamSection;
use App\Models\SpeakingPrompt;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SpeakingSheetImport implements ToCollection, WithHeadingRow
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
                'skill' => 'speaking',
                'instruction' => $row['part'] ?? '1'
            ]);

            SpeakingPrompt::firstOrCreate([
                'exam_section_id' => $section->id,
                'title' => $row['title'],
                'prompt_text' => $row['prompt_text']
            ]);
        }
    }
}