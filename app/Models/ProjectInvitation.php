<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    protected $fillable = ['project_id', 'email', 'token', 'expires_at'];

    protected $dates = ['expires_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }
}
