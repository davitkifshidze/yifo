<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'email',
        'publish',
        'facebook',
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }

}
