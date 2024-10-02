<?php

namespace App\Imports;

use App\Models\{Question,Answer};
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $question = new Question();
        $question->question    = $row['question'];    
        $question->subject_id  = $row['subject_id'];  
        $question->category_id = $row['category_id']; 
        $question->save();

        for ($i = 1; $i <= 6; $i++) 
        {
            $answerColumn = 'option_' . $i; 

            if (!empty($row[$answerColumn])) 
            {
                \Log::info("OpeionValue:".$answerColumn.":".$row[$answerColumn]);

                $answer = new Answer();
                $answer->question_id = $question->id;   
                $answer->answer      = $row[$answerColumn]; 
                $answer->is_correct  = ($i == $row['is_correct']) ? 1 : 0; 
                $answer->save();
            }
            
        }
        return $question;
    }
}
