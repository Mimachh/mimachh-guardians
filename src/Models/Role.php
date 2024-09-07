<?php

namespace Mimachh\Guardians;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    protected static function roleFactory()
    {
        return \Mimachh\Guardians\Database\Factories\RoleFactory::new();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
