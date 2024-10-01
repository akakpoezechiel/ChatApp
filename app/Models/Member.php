<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'groupe_id', 'role', 
        // Autres champs si nécessaire
    ];

    // Relation avec la table users
    public function user()
    {
        return $this->hasMany(User::class);
    }

    // Relation avec la table groups
    public function group()
    {
        return $this->hasMany(Groupe::class);
    }
}
