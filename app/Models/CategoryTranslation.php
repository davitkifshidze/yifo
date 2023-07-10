<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'locale',
        'name',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'facebook_meta_title',
        'facebook_meta_description',
        'twitter_meta_title',
        'twitter_meta_description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
