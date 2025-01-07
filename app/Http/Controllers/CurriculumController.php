<?php

namespace App\Http\Controllers;

use App\Exports\CurriculumExport;
use Illuminate\Http\Request;
use App\Imports\CurriculumImport;
use Maatwebsite\Excel\Facades\Excel;

class CurriculumController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new CurriculumImport, $request->file('file'));

        return back()->with('success', 'Importation réussie.');
    }

    public function export()
    {
        return Excel::download(new CurriculumExport, 'curriculums.xlsx');
    }
}
