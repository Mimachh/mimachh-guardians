<?php

namespace Mimachh\Guardians\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mimachh\Guardians\Database\Factories\RoleFactory;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];


       
        /** @return RoleFactory */
    protected static function newFactory()
    {
        return RoleFactory::new();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
