<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsTranslation extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'news_translations';

    protected $fillable = [
        'locale',
        'title',
        'intro',
        'text',
        'image',
        'thumb_image',
        'tag',
        'news_meta_title',
        'news_meta_keywords',
        'news_meta_description',
        'facebook_meta_title',
        'facebook_meta_description',
        'twitter_meta_title',
        'twitter_meta_description',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

}
