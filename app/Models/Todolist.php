<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'todolists_users',
            'todolist_id'
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
