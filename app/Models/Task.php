<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Task extends Model
{
    use Searchable;
    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
        'title' => 'string',
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

    /**
     * Champs indexés par Scout/Meilisearch
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
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

    public function isLate(): bool
    {
        return $this->date_end && $this->date_end < now() && $this->finished_at === null;
    }
}
