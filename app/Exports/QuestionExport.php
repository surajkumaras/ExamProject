<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'question',
            'option_1',
            'option_2',
            'option_3',
            'option_4',
            'option_5',
            'option_6',
            'is_correct',
            'subject_ID',
            'category_ID',
            'subject_name',
            'category_name',
        ];

        \Log::info("Headings");
    }

    public function collection()
    {
        $questions = Question::with(['answers', 'subject', 'category'])->get();

        $exportData = [];
        foreach ($questions as $question) {
            $row = [
                $question->question,
                $question->answers[0]['answer'] ?? '',
                $question->answers[1]['answer'] ?? '',
                $question->answers[2]['answer'] ?? '',
                $question->answers[3]['answer'] ?? '',
                $question->answers[4]['answer'] ?? '',
                $question->answers[5]['answer'] ?? '',
                null,  // Placeholder for is_correct
                $question->subject_id ?? 'null',
                $question->category_id ?? 'null',
                $question->subject->name ?? 'null',
                $question->category->name ?? 'null',
            ];

            // Determine the correct answer
            foreach ($question->answers as $index => $answer) {
                if (!empty($answer) && $answer['is_correct'] == 1) {
                    $row[7] = $index + 1;
                    break;
                }
            }

            $exportData[] = $row;
        }

        return collect($exportData);
    }

}
