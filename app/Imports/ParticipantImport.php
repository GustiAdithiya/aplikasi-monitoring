<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;

class ParticipantImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Participant([
            'no_reg' => $row['nomor_registrasi'],
            'no_identity' => $row['nomor_identitas'],
            'name' => $row['nama_lengkap'],
        ]);
    }
}
