<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantExport implements FromView, WithHeadings
{
    public function view(): View
    {
        return view('instance.report.format');
    }
    public function headings(): array
    {
        return [
            "nomor_registrasi",
            "nomor_identitas",
            "nama_lengkap",
        ];
    }
}
