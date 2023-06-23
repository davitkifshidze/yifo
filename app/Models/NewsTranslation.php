<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsTranslation extends Model
{
    use HasFactory;

    protected $table = 'news_translations';

    protected $fillable = [
        'locale',
        'title',
        'text',
        'image',
        'tag',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

}
