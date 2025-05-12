<?php

namespace App\Imports;

use App\Models\ExamSection;
use App\Models\ListeningAudio;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ListeningSheetImport implements ToCollection, WithHeadingRow
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
                'skill' => 'listening',
                'instruction' => $row['part'] ?? '1'
            ]);

            $audio = ListeningAudio::firstOrCreate([
                'exam_section_id' => $section->id,
                'title' => $row['audio_title'],
                'audio_url' => $row['audio_url']
            ]);

            $question = Question::create([
                'exam_section_id' => $section->id,
                'audio_id' => $audio->id,
                'question_text' => $row['question_text'],
                'question_type' => 'multiple_choice',
                'correct_choice_label' => strtoupper($row['correct_answer']),
                'score' => $row['score'] ?? 1.0,
            ]);

            foreach (['a', 'b', 'c', 'd'] as $label) {
                $field = 'option_' . $label;
                if (!empty($row[$field])) {
                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'label' => strtoupper($label),
                        'content' => $row[$field],
                    ]);
                }
            }
        }
    }
}