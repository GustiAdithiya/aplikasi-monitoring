<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'instance_id',
        'code',
        'name',
        'desc',
        'start_at',
        'finish_at',
        'status'
    ];

    public function instance(){
        return $this->belongsTo('App\Models\Instance');
    }
}
