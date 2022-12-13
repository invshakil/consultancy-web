<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Article extends BaseModel
{
    use HasFactory;

    protected $appends = ['image_url', 'thumb_image_url'];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'featured',
        'excerpt',
        'image',
        'published',
        'viewed'
    ];

    /**
     * Article Author Relation
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Article Countries Pivot Relation
     * @return BelongsToMany
     */

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'article_categories', 'article_id', 'category_id')->withPivot('id');
    }

    /**
     * Article Keyword pivot collection
     * @return BelongsToMany
     */
    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'article_keywords', 'article_id', 'keyword_id')->withPivot('id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url('articles/' . basename($this->image)) : null;
    }
    public function getThumbImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url('articles/' . basename($this->image)) : '';
    }

}
