<?php

namespace App\Imports;

use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\ToModel;

class CurriculumImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $curriculum = Curriculum::firstOrCreate([
            'name' => $row[0],
            'description' => $row[1],
            'school_id' => $row[2],
        ]);

        if (!empty($row[3])) {
            $subjectIds = explode(',', $row[3]); // Les IDs des matières
            $curriculum->subjects()->sync($subjectIds);
        }

        return $curriculum;
    }
}
