<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role',
        'birth_year', 'resume_path', 'is_banned'
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['is_banned' => 'boolean'];
    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }
}