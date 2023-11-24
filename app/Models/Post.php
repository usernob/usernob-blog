<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'content',
        'description',
        'view_count',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }

    public static function search($query, $start_date = null, $end_date = null) {
        # base start date
        $start_date = $start_date ? $start_date : now()->startOfMonth()->format('Y-m-d');
        # base end date
        $end_date = $end_date ? $end_date : now()->endOfMonth()->format('Y-m-d');
        return DB::table("posts")->where('title', 'like', "%{$query}%")
            ->whereBetween('created_at', [$start_date, $end_date]);
    }
}
