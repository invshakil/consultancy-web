<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'published',
        'description',
        'quality',
        'responsibility',
        'salary',
        'vacancy',
        'excerpt',
        'length',
        'exp_min',
        'exp_max',
        'industry',
        'type',
    ];

    public function country(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'job_countries', 'job_id', 'country_id')->withPivot('id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

}
