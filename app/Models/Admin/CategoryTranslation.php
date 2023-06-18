<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'name',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
