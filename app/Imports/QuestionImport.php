<?php

namespace App\Imports;

use App\Models\{Question,Answer};
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Create a new question
        $question = Question::create([
            'question'    => $row[0], // Column A in Excel
            'subject_id'  => $row[8], // Column I in Excel
            'category_id' => $row[9], // Column J in Excel
        ]);

        // Loop through options and create corresponding answers
        for ($i = 1; $i <= 6; $i++) 
        {
            if (!empty($row[$i])) 
            {
                Answer::create([
                    'question_id' => $question->id,   // Assign the newly created question's ID
                    'answer'      => $row[$i],        // Columns B to G in Excel
                    'is_correct'  => ($i == $row[7]) ? 1 : 0 // Column H in Excel
                ]);
            }
        }
    }
}
