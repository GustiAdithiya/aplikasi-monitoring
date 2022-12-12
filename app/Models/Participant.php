<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_reg',
        'no_identity',
        'name',
        'photo',
    ];

    public function package()
    {
        return $this->belongsToMany('App\Models\Package', 'package_participants');
    }
}
