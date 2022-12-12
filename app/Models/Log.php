<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_peserta',
        'datetime',
        'object_counting',
        'face_reg_counting',
        'head_gesture_counting', 
        'log',
        'base64_head_gest',
        'base64_obj_det'
    ];

    public function participant(){
        return $this->belongsTo('App\Models\Participant');
    }
}
