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
        'text',
        'image',
        'thumb_image',
        'tag',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

}
