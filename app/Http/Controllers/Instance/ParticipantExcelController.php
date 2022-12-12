<?php

namespace App\Http\Controllers\Instance;

use App\Exports\ParticipantExport;
use App\Http\Controllers\Controller;
use App\Imports\ParticipantImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantExcelController extends Controller
{
    public function downloadFormat() 
    {
        return Excel::download(new ParticipantExport, 'participant.xlsx');
    }

    public function excelImport(Request $request){
        $request->validate([
            'file' => 'required|max:50000|mimes:xlsx',
        ]);
        Excel::import(new ParticipantImport,$request()->file('file'));
        return back();
    }
}
