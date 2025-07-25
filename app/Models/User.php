<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
    public function tasksCreated(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }
    public function columnsCreated(): HasMany
    {
        return $this->hasMany(Column::class, 'created_by');
    }
    public function groupsCreated(): HasMany
    {
        return $this->hasMany(Group::class, 'created_by');
    }
    public function projectsCreated(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }
    public function categoriesCreated(): HasMany
    {
        return $this->hasMany(Category::class, 'created_by');
    }
}
