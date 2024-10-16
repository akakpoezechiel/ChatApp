<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;


    protected $fillable = [
        'filename',
        'group_id',
        'user_id',
    ];

    public function group()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
