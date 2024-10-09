<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    // Définition des colonnes mass assignables
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * Un groupe appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un groupe peut avoir plusieurs membres (users).
     */
    public function members()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Un groupe peut contenir plusieurs messages.
     */
    public function messages()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Un groupe peut avoir plusieurs fichiers.
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'groupe_user', 'groupe_id', 'user_id');
    }
}
