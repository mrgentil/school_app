<?php

namespace App\Exports;

use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\FromCollection;

class CurriculumExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Curriculum::with('subjects')->get()->map(function ($curriculum) {
            return [
                'name' => $curriculum->name,
                'description' => $curriculum->description,
                'school' => $curriculum->school->name,
                'subjects' => $curriculum->subjects->pluck('name')->join(', '),
            ];
        });
    }
}
