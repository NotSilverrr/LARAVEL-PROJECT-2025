<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
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
        'category_id'
    ];

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
}
