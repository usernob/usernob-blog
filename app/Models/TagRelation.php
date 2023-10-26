<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagRelation extends Model
{
    use HasFactory;

    protected $fillable = ['tag_id', 'post_id'];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
