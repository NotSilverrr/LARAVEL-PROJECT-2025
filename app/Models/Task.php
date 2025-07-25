<?php

namespace App\Models;

use App\Events\TaskCreated;
use App\Events\UserAddedToTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    public function scopeVisibleForUser($query, $user, $projectId)
    {
        $isAdmin = \App\Models\Project::find($projectId)
            ->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'admin')
            ->exists();
        if ($isAdmin) {
            return $query->where('project_id', $projectId);
        }
        $userGroupIds = $user->groups ? $user->groups->pluck('id')->toArray() : [];
        return $query->where('project_id', $projectId)
    ->where(function($q) use ($user, $userGroupIds) {
        $q->whereHas('users', function($q2) use ($user) {
            $q2->where('users.id', $user->id);
        });
        if (!empty($userGroupIds)) {
            $q->orWhereHas('groups', function($q3) use ($userGroupIds) {
                $q3->whereIn('groups.id', $userGroupIds);
            });
        }
        $q->orWhere('created_by', $user->id);
    });
    }

    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
    ];
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'finished_at',
        'date_start',
        'date_end',
        'created_by',
        'project_id',
        'column_id',
        'category_id',
        'status',
    ];

    protected static function booted(): void
    {
        static::created(function (Task $task) {
            // Déclencher l'événement après la création de la tâche
            // Mais seulement si des utilisateurs sont déjà assignés
            if ($task->users()->count() > 0) {
                event(new TaskCreated($task));
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Assigner un utilisateur à la tâche et déclencher l'événement
     */
    public function assignUser(User $user): void
    {
        dd('Assigning user to task', $user->id, $this->id);
        // Vérifier si l'utilisateur n'est pas déjà assigné
        if (!$this->users()->where('user_id', $user->id)->exists()) {
            $this->users()->attach($user);
            
            // Déclencher l'événement
            event(new UserAddedToTask($this, $user));
        }
    }

    /**
     * Assigner plusieurs utilisateurs à la tâche
     */
    public function assignUsers(array $userIds): void
    {
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $this->assignUser($user);
            }
        }
    }

    public function isLate(): bool
    {
        return $this->date_end && $this->date_end < now() && $this->finished_at === null;
    }
}
