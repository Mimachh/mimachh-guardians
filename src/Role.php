<?php

namespace Mimachh\Guardians;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
